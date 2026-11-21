---
id: java-l2-conditionals
title: "Percabangan: if dan else"
order: 2
xp: 20
---

## Coba ini

```java
public class Main {
    public static void main(String[] args) {
        int score = 75;

        if (score >= 70) {
            System.out.println("Lulus!");
        } else {
            System.out.println("Coba lagi");
        }
    }
}
```

Output:

```
Lulus!
```

## Cara kerja `if`

`if` memeriksa sebuah kondisi. Jika kondisinya `true`, kode di dalam `{ }` dijalankan.
Jika `false`, Java menjalankan kode di dalam `else`.

| Bagian | Fungsinya |
|---|---|
| `if (score >= 70)` | Kondisi yang diperiksa, ditulis di dalam tanda kurung `( )`. |
| `{ ... }` setelah `if` | Dijalankan jika kondisinya `true`. |
| `else { ... }` | Pilihan lain jika kondisinya `false`. `else` boleh tidak ditulis. |

Java tidak mewajibkan indentasi, tetapi tetap beri indentasi pada kode di dalam `{ }`
agar mudah dibaca.

## Lebih dari dua pilihan: `else if`

```java
int xp = 120;

if (xp >= 200) {
    System.out.println("Level 3");
} else if (xp >= 100) {
    System.out.println("Level 2");
} else {
    System.out.println("Level 1");
}
```

Output:

```
Level 2
```

Java memeriksa kondisi dari atas ke bawah dan **hanya menjalankan bagian pertama
yang kondisinya `true`**. Sisanya dilewati.

## Hati-hati: urutan kondisi

Karena Java berhenti di kondisi pertama yang `true`, periksa kondisi yang paling
ketat lebih dulu. Pada contoh di atas, `xp >= 200` harus diperiksa sebelum `xp >= 100`.
Jika urutannya dibalik, XP 250 akan masuk ke `Level 2`.

## Hati-hati: `=` di dalam `if`

```java
if (score = 70) { // Error: = menyimpan nilai, bukan membandingkan
```

Untuk membandingkan, pakai `==`: `if (score == 70)`. Java menolak `=` di dalam `if`
untuk `int`, jadi kesalahan ini langsung ketahuan saat compile.

## Ingat

- `if (kondisi) { ... }` menjalankan kode hanya jika kondisinya `true`.
- `else` dijalankan jika semua kondisi sebelumnya `false`.
- `else if` menambah pilihan. Hanya bagian pertama yang `true` yang dijalankan.
- Pakai `==` untuk membandingkan, bukan `=`.
