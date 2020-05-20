# admin

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install admin
```

## Kondisi Login

Untuk menambahkan kondisi where pada saat user login, tambahkan konfigurasi
seperti di bawah pada aplikias/module:

```php
return [
    'admin' => [
        'login' => [
            'where' => [
                'status' => 1
            ]
        ]
    ]
];
```

Bentuk seperti di atas akan menambahkan kondisi where `status = 1` pada saat pencarian
user untuk login.

## Recovery / Register

Untuk menambahkan link di halaman login ke halaman recovery password atau
register, tambahkan konfigurasi seperti di bawah pada module/aplikasi:

```php
return [
    'admin' => [
        'login' => [
            'recovery' => ['routeName', [], []],
            'register' => ['routeName', [], []]
        ]
    ]
];
```

## Object Filter

Module ini mendukung object filter yang ditangani oleh library external.
Untuk library yang penyedia object, harus mengimplementasikan interface
`Admin\Iface\ObjectFilter`, dan menambahkan konfigurasi seperti di bawah:

```php
return [
    'admin' => [
        'objectFilter' => [
            'handlers' => [
                '/name/' => '/Class/',
                'timezone' => 'Admin\\Library\\TimezoneFilter'
            ]
        ]
    ]
];
```

Masing-masing object provider harus memiliki method sebagai berikut:

### filter(array $cond): ?array

### lastError(): ?string

## Timeoze Filter

Module ini menambahkan satu library untuk memfilter timezone. Library ini menerima
query string:

1. `query` filter berdasarkan name
1. `what` filter berdasarkan continent
1. `country` filter berdasarkan negara ( ISO 3166-1 )