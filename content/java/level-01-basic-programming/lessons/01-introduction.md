---
id: java-l1-introduction
title: Pengenalan Pemrograman
order: 1
xp: 20
---

## Coba ini

```java
public class Main {
    public static void main(String[] args) {
        System.out.println("Halo, CodeQuest!");
        System.out.println("Saya sedang belajar Java.");
    }
}
```

Output:

```
Halo, CodeQuest!
Saya sedang belajar Java.
```

## Apa yang terjadi?

**Program** adalah daftar perintah untuk komputer. Java menjalankan perintah di dalam
`main` **satu per satu, dari atas ke bawah**.

| Bagian | Fungsinya |
|---|---|
| `public class Main { ... }` | Wadah untuk programmu. Nama file-nya harus `Main.java`. |
| `public static void main(String[] args) { ... }` | Titik awal program. Kodemu ditulis di dalam `{ }` ini. |
| `System.out.println("...");` | Menampilkan teks, lalu pindah ke baris baru. |
| `;` | Mengakhiri setiap perintah (statement). |

Untuk sekarang, anggap dua baris pertama sebagai kerangka yang dibutuhkan setiap
program Java. Arti setiap katanya akan kamu pelajari di level berikutnya.

## `println` vs `print`

`println` pindah ke baris baru setelah menampilkan teks. `print` tetap di baris yang sama.

```java
System.out.print("Code");
System.out.println("Quest");
System.out.println("Selesai");
```

Output:

```
CodeQuest
Selesai
```

## Komentar

Teks setelah `//` adalah **komentar**. Java melewatinya: komentar adalah catatan untuk manusia.

```java
// Baris ini dilewati
System.out.println("Baris ini dijalankan");
```

## Ingat

- Kodemu ditulis di dalam `main`, dan berjalan dari atas ke bawah.
- `System.out.println()` menampilkan satu baris teks.
- Setiap perintah diakhiri `;`.
- `//` mengawali komentar.
