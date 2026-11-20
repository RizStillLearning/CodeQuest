---
id: c-l1-introduction
title: Pengenalan Pemrograman
order: 1
xp: 20
---

## Coba ini

```c
#include <stdio.h>

int main(void) {
    printf("Halo, CodeQuest!\n");
    printf("Saya sedang belajar C.\n");
    return 0;
}
```

Output:

```
Halo, CodeQuest!
Saya sedang belajar C.
```

## Apa yang terjadi?

**Program** adalah daftar perintah untuk komputer. C menjalankan perintah di dalam
`main` **satu per satu, dari atas ke bawah**.

| Bagian | Fungsinya |
|---|---|
| `#include <stdio.h>` | Agar kamu bisa memakai `printf` dan alat input/output lainnya. |
| `int main(void) { ... }` | Titik awal program. Kodemu ditulis di dalam `{ }` ini. |
| `printf("...");` | Menampilkan teks. |
| `\n` | Pindah ke baris baru. |
| `return 0;` | Memberi tahu komputer bahwa program selesai dengan sukses. |
| `;` | Mengakhiri setiap perintah (statement). |

## `printf` tidak otomatis pindah baris

Tanpa `\n`, teks berikutnya akan berlanjut di baris yang sama:

```c
printf("Code");
printf("Quest\n");
printf("Selesai\n");
```

Output:

```
CodeQuest
Selesai
```

## Kode C perlu di-compile

Sebelum kode C bisa dijalankan, **compiler** harus mengubahnya menjadi program yang
dimengerti komputer. Contohnya, dengan compiler `gcc`:

```
gcc main.c -o main
./main
```

## Komentar

Teks setelah `//`, atau di antara `/*` dan `*/`, adalah **komentar**. C melewatinya.

```c
// Baris ini dilewati
/* Baris ini juga */
printf("Baris ini dijalankan\n");
```

## Ingat

- Kodemu ditulis di dalam `main`, dan berjalan dari atas ke bawah.
- `printf()` menampilkan teks. Tambahkan `\n` untuk pindah ke baris baru.
- Setiap perintah diakhiri `;`.
- Kode C harus di-compile sebelum bisa dijalankan.
