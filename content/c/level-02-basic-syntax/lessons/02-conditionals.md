---
id: c-l2-conditionals
title: "Percabangan: if dan else"
order: 2
xp: 20
---

## Coba ini

```c
#include <stdio.h>

int main(void) {
    int score = 75;

    if (score >= 70) {
        printf("Lulus!\n");
    } else {
        printf("Coba lagi\n");
    }
    return 0;
}
```

Output:

```
Lulus!
```

## Cara kerja `if`

`if` memeriksa sebuah kondisi. Jika kondisinya benar, kode di dalam `{ }` dijalankan.
Jika salah, C menjalankan kode di dalam `else`.

| Bagian | Fungsinya |
|---|---|
| `if (score >= 70)` | Kondisi yang diperiksa, ditulis di dalam tanda kurung `( )`. |
| `{ ... }` setelah `if` | Dijalankan jika kondisinya benar. |
| `else { ... }` | Pilihan lain jika kondisinya salah. `else` boleh tidak ditulis. |

C tidak mewajibkan indentasi, tetapi tetap beri indentasi pada kode di dalam `{ }`
agar mudah dibaca.

## Lebih dari dua pilihan: `else if`

```c
int xp = 120;

if (xp >= 200) {
    printf("Level 3\n");
} else if (xp >= 100) {
    printf("Level 2\n");
} else {
    printf("Level 1\n");
}
```

Output:

```
Level 2
```

C memeriksa kondisi dari atas ke bawah dan **hanya menjalankan bagian pertama
yang kondisinya benar**. Sisanya dilewati.

## Hati-hati: urutan kondisi

Karena C berhenti di kondisi pertama yang benar, periksa kondisi yang paling ketat
lebih dulu. Pada contoh di atas, `xp >= 200` harus diperiksa sebelum `xp >= 100`.
Jika urutannya dibalik, XP 250 akan masuk ke `Level 2`.

## Hati-hati: `=` di dalam `if`

Ini kesalahan yang sangat sering terjadi di C:

```c
int score = 50;

if (score = 100) {           // salah: = menyimpan 100 ke score
    printf("Sempurna!\n");   // tetap dijalankan!
}
```

Output:

```
Sempurna!
```

`score = 100` **menyimpan** 100 ke `score`. Di C, angka selain 0 dianggap benar,
jadi kondisinya selalu benar. Berbeda dengan Java, C tetap mau menjalankan kode ini,
paling-paling compiler hanya memberi peringatan (warning).
Untuk membandingkan, pakai `==`: `if (score == 100)`.

## Ingat

- `if (kondisi) { ... }` menjalankan kode hanya jika kondisinya benar.
- `else` dijalankan jika semua kondisi sebelumnya salah.
- `else if` menambah pilihan. Hanya bagian pertama yang benar yang dijalankan.
- Pakai `==` untuk membandingkan. `=` di dalam `if` tidak membuat error, tetapi hasilnya salah.
