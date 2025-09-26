# User Fields Documentation

## 📋 Field Baru yang Ditambahkan ke Tabel Users

### 1. **tier** (ENUM)
- **Type:** ENUM
- **Values:** 'New Born', 'Tier 1', 'Tier 2', 'Tier 3'
- **Default:** 'New Born'
- **Nullable:** No
- **Description:** Level tier user dalam sistem

### 2. **role** (ENUM)
- **Type:** ENUM
- **Values:** 'Administrator', 'Management', 'Admin Officer', 'User', 'Client'
- **Default:** 'User'
- **Nullable:** No
- **Description:** Role/peran user dalam sistem

### 3. **start_work** (DATE)
- **Type:** DATE
- **Default:** NULL
- **Nullable:** Yes
- **Description:** Tanggal mulai bekerja (nullable)

### 4. **birthday** (DATE)
- **Type:** DATE
- **Default:** NULL
- **Nullable:** Yes
- **Description:** Tanggal lahir user (nullable)

### 5. **status** (ENUM)
- **Type:** ENUM
- **Values:** 'Active', 'Inactive'
- **Default:** 'Active'
- **Nullable:** No
- **Description:** Status aktif/tidak aktif user

## 🔧 Model User Updates

### Constants yang Ditambahkan:
```php
// Tier constants
const TIER_NEW_BORN = 'New Born';
const TIER_1 = 'Tier 1';
const TIER_2 = 'Tier 2';
const TIER_3 = 'Tier 3';

// Role constants
const ROLE_ADMINISTRATOR = 'Administrator';
const ROLE_MANAGEMENT = 'Management';
const ROLE_ADMIN_OFFICER = 'Admin Officer';
const ROLE_USER = 'User';
const ROLE_CLIENT = 'Client';

// Status constants
const STATUS_ACTIVE = 'Active';
const STATUS_INACTIVE = 'Inactive';
```

### Fillable Fields:
```php
protected $fillable = [
    'name',
    'email',
    'password',
    'tier',        // NEW
    'role',        // NEW
    'start_work',  // NEW
    'birthday',    // NEW
    'status',      // NEW
];
```

### Casts:
```php
protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'start_work' => 'date',  // NEW
        'birthday' => 'date',    // NEW
    ];
}
```

## 🛠️ Helper Methods

### Static Methods:
```php
// Get all tier options
User::getTierOptions()

// Get all role options  
User::getRoleOptions()

// Get all status options
User::getStatusOptions()
```

### Instance Methods:
```php
// Check if user is administrator
$user->isAdministrator()

// Check if user is management
$user->isManagement()

// Check if user is active
$user->isActive()
```

## 📊 Contoh Penggunaan

### Membuat User Baru:
```php
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => bcrypt('password'),
    'tier' => 'Tier 1',
    'role' => 'User',
    'start_work' => '2023-01-15',
    'birthday' => '1990-05-20',
    'status' => 'Active',
]);
```

### Query Users:
```php
// Get all administrators
$admins = User::where('role', User::ROLE_ADMINISTRATOR)->get();

// Get all active users
$activeUsers = User::where('status', User::STATUS_ACTIVE)->get();

// Get users by tier
$tier1Users = User::where('tier', User::TIER_1)->get();
```

### Update User:
```php
$user = User::find(1);
$user->update([
    'tier' => 'Tier 2',
    'role' => 'Management',
    'status' => 'Active'
]);
```

## 🎯 Business Logic Examples

### Role-based Access:
```php
if ($user->isAdministrator()) {
    // Admin can do everything
    return true;
}

if ($user->isManagement()) {
    // Management can manage users
    return $this->canManageUsers();
}
```

### Status Check:
```php
if (!$user->isActive()) {
    throw new Exception('User account is inactive');
}
```

### Tier-based Features:
```php
switch ($user->tier) {
    case User::TIER_3:
        // Premium features
        break;
    case User::TIER_2:
        // Advanced features
        break;
    case User::TIER_1:
        // Basic features
        break;
    case User::TIER_NEW_BORN:
        // Limited features
        break;
}
```

## 🗄️ Database Schema

```sql
-- Field yang ditambahkan ke tabel users
ALTER TABLE users ADD COLUMN tier VARCHAR(20) DEFAULT 'New Born';
ALTER TABLE users ADD COLUMN role VARCHAR(20) DEFAULT 'User';
ALTER TABLE users ADD COLUMN start_work DATE;
ALTER TABLE users ADD COLUMN birthday DATE;
ALTER TABLE users ADD COLUMN status VARCHAR(20) DEFAULT 'Active';
```

## 📝 Migration File

File migration: `database/migrations/2025_09_25_194900_add_fields_to_users_table.php`

### Up Method:
```php
Schema::table('users', function (Blueprint $table) {
    $table->enum('tier', ['New Born', 'Tier 1', 'Tier 2', 'Tier 3'])->default('New Born');
    $table->enum('role', ['Administrator', 'Management', 'Admin Officer', 'User', 'Client'])->default('User');
    $table->date('start_work')->nullable();
    $table->date('birthday')->nullable();
    $table->enum('status', ['Active', 'Inactive'])->default('Active');
});
```

### Down Method:
```php
Schema::table('users', function (Blueprint $table) {
    $table->dropColumn(['tier', 'role', 'start_work', 'birthday', 'status']);
});
```

## 🧪 Testing

### Seeder untuk Test Data:
File: `database/seeders/UserSeeder.php`

Membuat 5 user dengan berbagai kombinasi field:
- Administrator (Tier 3)
- Management (Tier 2)  
- Admin Officer (Tier 1)
- Regular User (New Born)
- Client User (New Born)

### Jalankan Seeder:
```bash
docker exec ppm-app php artisan db:seed --class=UserSeeder
```

## 🔍 Verification

### Cek Struktur Tabel:
```sql
SELECT column_name, data_type, is_nullable, column_default 
FROM information_schema.columns 
WHERE table_name = 'users' 
ORDER BY ordinal_position;
```

### Cek Data:
```sql
SELECT id, name, email, tier, role, start_work, birthday, status 
FROM users;
```

## ⚠️ Important Notes

1. **Default Values:** Semua field baru memiliki default value yang sesuai
2. **Nullable Fields:** `start_work` dan `birthday` bisa NULL
3. **Enum Values:** Pastikan menggunakan konstanta yang sudah didefinisikan
4. **Date Format:** Gunakan format 'Y-m-d' untuk date fields
5. **Backward Compatibility:** Field lama tetap berfungsi normal

## 🚀 Next Steps

1. Update form registration untuk field baru
2. Update user profile/edit forms
3. Implement role-based middleware
4. Create user management interface
5. Add validation rules untuk field baru


