# admin

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install admin
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