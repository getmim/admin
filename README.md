# admin

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install admin
```

## Login Middleware

Semua request ke admin akan melewati middleware `Login` yang bertugas memastikan user yang
sedang login sudah memenuhi kriteria user yang boleh masuk berdasarkan properti konfigurasi
`config->admin->login->where`. Untuk melewati middleware tersebut pada suatu route, tambahkan
konfigurasi seperti di bawah pada aplikasi / module:

```php
return [
    'admin' => [
        'middleware' => [
            'login' => [
                'ignore' => [
                    'adminMeLogin' => true
                ]
            ]
        ]
    ]
];
```

Bentuk konfigurasi seperti di atas akan memastikan route dengan nama `adminMeLogin` tidak
akan melewati middleware `Auth`.

## Google Authenticator

Tambahkan konfigurasi seperti di bawah untuk menambahkan google authenticator
pada halaman login

```php
return [
    'admin' => [
        'login' => [
            'googleauthenticator' => true
        ]
    ]
];
```

Pastikan module `lib-user-auth-google-auth` sudah terpasang.

## reCaptcha

Tambahkan konfigurasi seperti di bawah untuk menambahkan google recaptcha pada
halaman login

```php
return [
    'admin' => [
        'login' => [
            'recaptcha' => true
        ]
    ]
];
```

## Captcha

Tambahkan konfigurasi seperti di bawah untuk menambahkan captcha pada
halaman login

```php
return [
    'admin' => [
        'login' => [
            'captcha' => true
        ]
    ]
];
```

Pastikan module `lib-recaptcha` sudah terpasang.

## Site Handshake

Untuk meneruskan session login user ke frontpage ketika klik `Back to site` dari halman
admin jika domain name halaman admin berbeda dengan halaman site, tambahkan konfigurasi
seperti di bawah pada aplikasi:

```php
return [
    'admin' => [
        'login' => [
            'frontpage' => true
        ]
    ]
];
```

Pastikan module `admin-user-handshake` dan `site-user-handshake` terpasang agar proses
ini bisa berjalan dengan baik.

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
