---
id: java-l4-functions
title: Membuat Method
order: 1
xp: 20
---

## Coba ini

```java
public class Main {
    static void greet() {
        System.out.println("Halo!");
        System.out.println("Selamat belajar di CodeQuest.");
    }

    public static void main(String[] args) {
        greet();
        greet();
    }
}
```

Output:

```
Halo!
Selamat belajar di CodeQuest.
Halo!
Selamat belajar di CodeQuest.
```

## Apa itu method?

**Fungsi** adalah sekumpulan kode yang diberi nama. Setelah dibuat, fungsi bisa
**dipanggil** berkali-kali tanpa perlu menulis ulang kodenya. Di Java, fungsi disebut **method**.

| Bagian | Fungsinya |
|---|---|
| `static` | Untuk sekarang, selalu tulis `static`. Artinya akan kamu pelajari di level OOP. |
| `void` | Method ini tidak mengembalikan nilai. |
| `greet()` | Nama method, diikuti tanda kurung untuk parameter (di sini kosong). |
| `{ ... }` | Isi method, yang dijalankan setiap kali method dipanggil. |
| `greet();` di dalam `main` | Memanggil method. |

Method ditulis **di dalam** `public class Main { }`, tetapi **di luar** `main`.

Kamu sebenarnya sudah memakai method sejak Level 1: `System.out.println()`,
`Integer.parseInt()`, dan `input.nextInt()` adalah method bawaan Java.

Mulai dari sini, contoh menampilkan method dan `main` tanpa `public class Main { }`
di sekelilingnya.

## Alur program saat method dipanggil

```java
static void greet() {
    System.out.println("Halo!");
}

public static void main(String[] args) {
    System.out.println("Mulai");
    greet();
    System.out.println("Selesai");
}
```

Output:

```
Mulai
Halo!
Selesai
```

Program selalu dimulai dari `main`. Saat `greet()` dipanggil, Java menjalankan isi
`greet`, lalu kembali ke baris setelah pemanggilan.

Di Java, urutan penulisan method tidak penting: method boleh ditulis di atas atau di bawah `main`.

Nama method mengikuti aturan yang sama seperti nama variabel (camelCase). Biasakan memakai
kata kerja, seperti `showScore` atau `addXp`.

## Ingat

- `static void nama() { ... }` membuat method yang tidak mengembalikan nilai.
- `nama();` memanggil method, dan isinya dijalankan setiap kali dipanggil.
- Method ditulis di dalam class, di luar `main`. Program selalu dimulai dari `main`.
