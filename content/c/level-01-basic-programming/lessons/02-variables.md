---
id: c-l1-variables
title: Variabel
order: 2
xp: 20
---

## Coba ini

```c
#include <stdio.h>

int main(void) {
    int age = 20;
    int xp = 50;
    printf("Umur: %d\n", age);
    printf("XP: %d\n", xp);
    return 0;
}
```

Output:

```
Umur: 20
XP: 50
```

## Apa itu variabel?

**Variabel** adalah kotak berlabel yang menyimpan sebuah nilai. Di C, setiap kotak
punya **tipe** yang menentukan jenis nilai yang bisa disimpannya:

```
int    age  =  20;
tipe   nama    nilai
```

## Menampilkan variabel

`printf` memakai **placeholder** untuk menampilkan nilai variabel. `%d` adalah
placeholder untuk `int`. Variabelnya ditulis setelah teks, dipisahkan koma:

```c
printf("Umur: %d\n", age);
```

Mulai dari sini, contoh hanya menampilkan kode di dalam `main`.

## Mengubah nilai

Tipe hanya ditulis sekali, saat variabel dibuat. Setelah itu, cukup tulis namanya:

```c
int score = 10;
score = 15;
printf("%d\n", score); // 15
```

Kamu bisa memakai nilai variabel saat ini untuk menghitung nilai barunya:

```c
int xp = 50;
xp = xp + 10;
printf("%d\n", xp); // 60
```

## Hati-hati: selalu beri nilai awal

```c
int score;             // tanpa nilai awal
printf("%d\n", score); // bisa menampilkan angka acak!
```

Variabel C tanpa nilai awal berisi sisa data apa pun yang ada di memori.
Selalu tulis `int score = 0;`.

## Aturan penamaan

| Boleh | Tidak boleh |
|---|---|
| `total_xp` | `total xp` (tidak boleh ada spasi) |
| `level2` | `2level` (tidak boleh diawali angka) |
| `user_name` | `user-name` (tidak boleh ada tanda hubung) |

Nama variabel **membedakan huruf besar dan kecil**: `Age` dan `age` adalah dua variabel
yang berbeda. Gaya penulisan C biasanya memakai huruf kecil yang disambung dengan `_`,
seperti `total_xp`.

## Ingat

- Buat variabel dengan `tipe nama = nilai;`.
- Tampilkan `int` dengan `printf("%d\n", nama);`.
- Selalu beri variabel nilai awal.
