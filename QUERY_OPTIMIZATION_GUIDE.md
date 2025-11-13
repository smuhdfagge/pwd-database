# Query Optimization Best Practices

## Leveraging the New Indexes

Now that indexes are in place, here are code patterns to maximize performance:

### ✅ GOOD: Queries That Use Indexes

#### 1. Profile Filtering (Uses: verified, state, disability_type_id indexes)
```php
// Single filter - uses verified index
$verified = PlwdProfile::where('verified', true)->get();

// Multiple filters - uses composite index (verified + state)
$lagosVerified = PlwdProfile::where('verified', true)
    ->where('state', 'Lagos')
    ->get();

// With disability type - uses composite index (verified + disability_type_id)
$verifiedByType = PlwdProfile::where('verified', true)
    ->where('disability_type_id', 2)
    ->get();
```

#### 2. User Management (Uses: role, status indexes)
```php
// Filter by role - uses role index
$admins = User::where('role', 'admin')->get();

// Filter by role and status - uses composite index (role + status)
$activePlwds = User::where('role', 'plwd')
    ->where('status', 'active')
    ->get();
```

#### 3. Audit Logs (Uses: action, model_type, created_at indexes)
```php
// By action - uses action index
$approvals = AuditLog::where('action', 'PLWD Approved')->get();

// By model type - uses model_type index
$profileLogs = AuditLog::where('model_type', PlwdProfile::class)->get();

// Polymorphic lookup - uses composite index (model_type + model_id)
$profileLogs = AuditLog::where('model_type', PlwdProfile::class)
    ->where('model_id', 123)
    ->get();

// Date range - uses created_at index
$recentLogs = AuditLog::where('created_at', '>=', now()->subDays(7))->get();
```

#### 4. Document Management (Uses: type, plwd_id + type indexes)
```php
// By document type - uses type index
$idCards = Upload::where('type', 'ID Card')->get();

// User-specific by type - uses composite index (plwd_id + type)
$userDocs = Upload::where('plwd_id', $profileId)
    ->where('type', 'Medical Report')
    ->get();
```

---

### ❌ AVOID: Patterns That Bypass Indexes

#### 1. Leading Wildcards in LIKE Queries
```php
// ❌ BAD: Leading wildcard bypasses index
$users = User::where('email', 'LIKE', '%@gmail.com')->get();

// ✅ BETTER: Use full-text search or exact match
$user = User::where('email', 'john@gmail.com')->first();

// ✅ BEST: Trailing wildcard can use index
$users = User::where('email', 'LIKE', 'john%')->get();
```

#### 2. Functions on Indexed Columns
```php
// ❌ BAD: Function on indexed column prevents index use
$profiles = PlwdProfile::whereRaw('YEAR(created_at) = 2024')->get();

// ✅ GOOD: Use range queries instead
$profiles = PlwdProfile::whereBetween('created_at', 
    ['2024-01-01', '2024-12-31']
)->get();
```

#### 3. OR Conditions (Sometimes)
```php
// ❌ MIGHT BE SLOW: OR across different columns
$profiles = PlwdProfile::where('state', 'Lagos')
    ->orWhere('gender', 'Female')
    ->get();

// ✅ BETTER: Use UNION or separate queries with union()
$lagos = PlwdProfile::where('state', 'Lagos');
$females = PlwdProfile::where('gender', 'Female');
$profiles = $lagos->union($females)->get();
```

---

### 🚀 Performance Tips

#### 1. Always Eager Load Relationships
```php
// ❌ BAD: N+1 query problem
$profiles = PlwdProfile::all();
foreach ($profiles as $profile) {
    echo $profile->user->name; // Separate query per profile!
}

// ✅ GOOD: Eager loading
$profiles = PlwdProfile::with(['user', 'disabilityType', 'educationLevel'])->get();
foreach ($profiles as $profile) {
    echo $profile->user->name; // No extra queries
}
```

#### 2. Use Pagination for Large Datasets
```php
// ❌ BAD: Loading all records
$allProfiles = PlwdProfile::all();

// ✅ GOOD: Paginate
$profiles = PlwdProfile::paginate(20);

// ✅ BETTER: With eager loading
$profiles = PlwdProfile::with(['user', 'disabilityType'])
    ->paginate(20);
```

#### 3. Select Only Needed Columns
```php
// ❌ BAD: Loading all columns
$users = User::all();

// ✅ GOOD: Select specific columns
$users = User::select(['id', 'name', 'email'])->get();
```

#### 4. Use exists() Instead of count() for Checks
```php
// ❌ SLOWER: Count all records
if (PlwdProfile::where('verified', false)->count() > 0) {
    // ...
}

// ✅ FASTER: Check existence only
if (PlwdProfile::where('verified', false)->exists()) {
    // ...
}
```

#### 5. Cache Frequently Accessed Data
```php
// Cache dashboard statistics for 5 minutes
$stats = Cache::remember('dashboard_stats', 300, function () {
    return [
        'totalPlwds' => PlwdProfile::count(),
        'verifiedPlwds' => PlwdProfile::where('verified', true)->count(),
        'pendingPlwds' => PlwdProfile::where('verified', false)->count(),
    ];
});
```

---

### 📊 Monitoring Query Performance

#### Enable Query Logging in Development
```php
// In a controller method or tinker
use Illuminate\Support\Facades\DB;

DB::enableQueryLog();

// Your queries here
$profiles = PlwdProfile::where('verified', true)->get();

// See executed queries
dd(DB::getQueryLog());
```

#### Install Laravel Debugbar
```bash
composer require barryvdh/laravel-debugbar --dev
```

#### Check Slow Queries
```php
// In AppServiceProvider boot method
if (config('app.debug')) {
    DB::listen(function ($query) {
        if ($query->time > 100) { // Log queries taking more than 100ms
            \Log::warning('Slow query: ' . $query->sql, [
                'time' => $query->time,
                'bindings' => $query->bindings
            ]);
        }
    });
}
```

---

### 🎯 Index Usage Examples from Existing Code

#### AdminController::index() - Dashboard
```php
// Uses: verified index
$verifiedPlwds = PlwdProfile::where('verified', true)->count();
$pendingPlwds = PlwdProfile::where('verified', false)->count();

// Uses: gender index
$plwdsByGender = PlwdProfile::selectRaw('gender, count(*) as count')
    ->groupBy('gender')
    ->get();

// Uses: state index
$plwdsByState = PlwdProfile::selectRaw('state, count(*) as count')
    ->groupBy('state')
    ->orderBy('count', 'desc')
    ->take(10)
    ->get();
```

#### AdminController::listPlwds() - Filtering
```php
$query = PlwdProfile::with(['user', 'disabilityType', 'educationLevel']);

// Uses: state index
if ($request->filled('state')) {
    $query->where('state', $request->state);
}

// Uses: disability_type_id foreign key index
if ($request->filled('disability_type')) {
    $query->where('disability_type_id', $request->disability_type);
}

// Uses: verified index
if ($request->filled('verified')) {
    $query->where('verified', $request->verified);
}
```

---

### 🔍 Testing Index Effectiveness

#### Explain Query Plan
```php
// In tinker
$query = PlwdProfile::where('verified', true)
    ->where('state', 'Lagos')
    ->toSql();

DB::select("EXPLAIN " . $query);
```

#### Benchmark Queries
```php
$start = microtime(true);

// Your query
$profiles = PlwdProfile::where('verified', true)
    ->where('state', 'Lagos')
    ->get();

$end = microtime(true);
echo "Query took: " . ($end - $start) . " seconds\n";
```

---

### 📝 Key Takeaways

1. **Indexes are most effective when:**
   - Filtering with WHERE clauses
   - Joining tables
   - Sorting with ORDER BY
   - Grouping with GROUP BY

2. **Indexes won't help with:**
   - Full table scans (SELECT * without WHERE)
   - Leading wildcard LIKE searches ('%text')
   - Functions on indexed columns (YEAR(date))
   - Very small tables (< 1000 rows)

3. **Best practices:**
   - Always use eager loading for relationships
   - Paginate large result sets
   - Cache frequently accessed data
   - Monitor slow queries in production
   - Select only needed columns

4. **Trade-offs:**
   - Indexes speed up reads but slow down writes (slightly)
   - More indexes = more storage space
   - For this read-heavy application: **Worth it!**

---

**Remember:** The indexes are now in place and working. Just write clean Laravel queries using `where()`, `orderBy()`, and `with()`, and the database will automatically use the appropriate indexes for optimal performance.
