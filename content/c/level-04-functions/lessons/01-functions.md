---
id: c-l4-functions
title: Membuat Fungsi
order: 1
xp: 20
---

## Coba ini

```c
#include <stdio.h>

void greet(void) {
    printf("Halo!\n");
    printf("Selamat belajar di CodeQuest.\n");
}

int main(void) {
    greet();
    greet();
    return 0;
}
```

Output:

```
Halo!
Selamat belajar di CodeQuest.
Halo!
Selamat belajar di CodeQuest.
```

## Apa itu fungsi?

**Fungsi** adalah sekumpulan kode yang diberi nama. Setelah dibuat, fungsi bisa
**dipanggil** berkali-kali tanpa perlu menulis ulang kodenya.

| Bagian | Fungsinya |
|---|---|
| `void` (yang pertama) | Fungsi ini tidak mengembalikan nilai. |
| `greet` | Nama fungsi. |
| `(void)` | Fungsi ini tidak punya parameter. |
| `{ ... }` | Isi fungsi, yang dijalankan setiap kali fungsi dipanggil. |
| `greet();` di dalam `main` | Memanggil fungsi. |

Kamu sebenarnya sudah menulis fungsi sejak Level 1: `main` adalah fungsi! `printf` dan
`scanf` juga fungsi, yang berasal dari `stdio.h`.

Mulai dari sini, contoh tidak menampilkan baris `#include`.

## Alur program saat fungsi dipanggil

```c
void greet(void) {
    printf("Halo!\n");
}

int main(void) {
    printf("Mulai\n");
    greet();
    printf("Selesai\n");
    return 0;
}
```

Output:

```
Mulai
Halo!
Selesai
```

Program selalu dimulai dari `main`. Saat `greet()` dipanggil, C menjalankan isi `greet`,
lalu kembali ke baris setelah pemanggilan.

## Hati-hati: fungsi harus dikenal sebelum dipanggil

C membaca kode dari atas ke bawah. Jika `greet` ditulis **di bawah** `main`, compiler belum
mengenalnya saat `main` memanggilnya, dan memberi peringatan atau error (tergantung versi
compiler-nya). Ada dua cara mengatasinya:

1. Tulis fungsinya **di atas** `main`, seperti contoh di atas.
2. Tulis **deklarasi** (prototype) di atas `main`, lalu isi fungsinya di bawah:

```c
void greet(void); // deklarasi: "fungsi ini ada"

int main(void) {
    greet();
    return 0;
}

void greet(void) {
    printf("Halo!\n");
}
```

Nama fungsi mengikuti aturan yang sama seperti nama variabel. Biasakan memakai kata kerja,
seperti `show_score` atau `add_xp`.

## Ingat

- `void nama(void) { ... }` membuat fungsi tanpa nilai kembali dan tanpa parameter.
- `nama();` memanggil fungsi, dan isinya dijalankan setiap kali dipanggil.
- Tulis fungsi di atas `main`, atau tulis deklarasinya di atas `main`.
