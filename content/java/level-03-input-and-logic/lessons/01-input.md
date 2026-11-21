---
id: java-l3-input
title: Input dari Pengguna
order: 1
xp: 20
---

## Coba ini

```java
import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        Scanner input = new Scanner(System.in);

        System.out.print("Siapa namamu? ");
        String name = input.nextLine();
        System.out.println("Halo, " + name + "!");
    }
}
```

Output, jika kamu mengetik `Budi` lalu menekan Enter:

```
Siapa namamu? Budi
Halo, Budi!
```

## Cara kerja `Scanner`

| Bagian | Fungsinya |
|---|---|
| `import java.util.Scanner;` | Agar kamu bisa memakai `Scanner`. Ditulis paling atas, sebelum `public class`. |
| `Scanner input = new Scanner(System.in);` | Membuat `Scanner` bernama `input` yang membaca dari keyboard (`System.in`). Cukup dibuat sekali. |
| `input.nextLine()` | Menunggu pengguna mengetik lalu menekan Enter, dan menghasilkan satu baris teks. |

Mulai dari sini, contoh hanya menampilkan kode di dalam `main`. Jangan lupa menulis
`import java.util.Scanner;` di paling atas.

## Membaca angka

| Method | Membaca |
|---|---|
| `input.nextInt()` | bilangan bulat (`int`) |
| `input.nextDouble()` | bilangan desimal (`double`) |
| `input.nextLine()` | satu baris teks (`String`) |

```java
Scanner input = new Scanner(System.in);
System.out.print("Berapa umurmu? ");
int age = input.nextInt();
System.out.println("Tahun depan umurmu " + (age + 1));
```

Output, jika kamu mengetik `20`:

```
Berapa umurmu? 20
Tahun depan umurmu 21
```

Perhatikan tanda kurung di `(age + 1)`. Tanpa tanda kurung, Java menyambung teks dari kiri
ke kanan: `"Tahun depan umurmu " + age + 1` menghasilkan `Tahun depan umurmu 201`.

Jika pengguna mengetik sesuatu yang bukan angka, `nextInt()` menyebabkan error
(`InputMismatchException`). Cara menangani error seperti ini akan kamu pelajari di level selanjutnya.

## Hati-hati: `nextInt()` lalu `nextLine()`

```java
Scanner input = new Scanner(System.in);
System.out.print("Umur: ");
int age = input.nextInt();
input.nextLine(); // buang Enter yang tersisa
System.out.print("Nama: ");
String name = input.nextLine();
System.out.println("Halo, " + name + "!");
```

`nextInt()` hanya membaca angkanya. Enter yang kamu tekan setelah angka masih tersisa,
dan `nextLine()` berikutnya akan langsung membaca Enter itu sebagai baris kosong.
Tambahkan `input.nextLine();` setelah `nextInt()` untuk membuang Enter tersebut.

## Ingat

- Buat `Scanner input = new Scanner(System.in);` sekali, lalu baca dengan `nextLine()`,
  `nextInt()`, atau `nextDouble()`.
- Tulis `import java.util.Scanner;` di paling atas.
- Setelah `nextInt()`, panggil `input.nextLine();` sebelum membaca teks.
