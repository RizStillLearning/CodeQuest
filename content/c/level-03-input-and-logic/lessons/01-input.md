---
id: c-l3-input
title: Input dari Pengguna
order: 1
xp: 20
---

## Coba ini

```c
#include <stdio.h>

int main(void) {
    int age = 0;
    printf("Berapa umurmu? ");
    scanf("%d", &age);
    printf("Tahun depan umurmu %d\n", age + 1);
    return 0;
}
```

Output, jika kamu mengetik `20` lalu menekan Enter:

```
Berapa umurmu? 20
Tahun depan umurmu 21
```

## Cara kerja `scanf`

| Bagian | Fungsinya |
|---|---|
| `scanf(...)` | Menunggu pengguna mengetik lalu menekan Enter, dan menyimpan hasilnya ke variabel. |
| `"%d"` | Jenis data yang dibaca. Placeholder-nya mirip dengan `printf`. |
| `&age` | **Alamat** variabel `age`, yaitu tempat nilai akan disimpan. |

`scanf` perlu tahu **di mana** nilai harus disimpan, jadi kamu memberikan alamat
variabelnya dengan `&`. Kamu akan mempelajari alamat (pointer) lebih dalam di level selanjutnya.

## Hati-hati: jangan lupa `&`

```c
scanf("%d", age);  // salah: tanpa &, program bisa crash
```

Tanpa `&`, `scanf` mencoba menyimpan angka di tempat yang salah. Programnya bisa
crash atau menghasilkan nilai yang aneh.

## Placeholder untuk `scanf`

| Tipe | Contoh |
|---|---|
| `int` | `scanf("%d", &age);` |
| `double` | `scanf("%lf", &height);` |
| teks (satu kata) | `scanf("%49s", name);` |

Untuk `double`, `scanf` memakai `%lf` (huruf L kecil dan f), bukan `%f` seperti `printf`.

## Membaca teks

```c
char name[50] = "";
printf("Siapa namamu? ");
scanf("%49s", name);
printf("Halo, %s!\n", name);
```

Output, jika kamu mengetik `Budi Santoso`:

```
Siapa namamu? Budi Santoso
Halo, Budi!
```

- `char name[50]` adalah kotak untuk teks sampai 49 huruf (1 tempat dipakai untuk
  penanda akhir teks). `%49s` membatasi bacaan agar tidak melebihi kotaknya.
- Untuk teks, **tidak** perlu `&`.
- `%s` hanya membaca **satu kata**: berhenti di spasi pertama, jadi yang tersimpan hanya `Budi`.

## Ingat

- `scanf("%d", &age);` membaca angka ke dalam `age`.
- Jangan lupa `&` sebelum nama variabel angka.
- `double` dibaca dengan `%lf`. Teks dibaca dengan `%49s`, tanpa `&`.
