---
id: java-l1-variables
title: Variabel
order: 2
xp: 20
---

## Coba ini

```java
public class Main {
    public static void main(String[] args) {
        String name = "Budi";
        int age = 20;
        System.out.println(name);
        System.out.println(age);
    }
}
```

Output:

```
Budi
20
```

## Apa itu variabel?

**Variabel** adalah kotak berlabel yang menyimpan sebuah nilai. Di Java, setiap kotak
punya **tipe** yang menentukan jenis nilai yang bisa disimpannya:

```
int    age  =  20;
tipe   nama    nilai
```

`String name = "Budi";` artinya: buat kotak bernama `name` yang menyimpan teks,
lalu masukkan `"Budi"` ke dalamnya.

Mulai dari sini, contoh hanya menampilkan kode di dalam `main`.

## Mengubah nilai

Tipe hanya ditulis sekali, saat variabel dibuat. Setelah itu, cukup tulis namanya:

```java
int score = 10;
score = 15;
System.out.println(score); // 15
```

Kamu bisa memakai nilai variabel saat ini untuk menghitung nilai barunya:

```java
int xp = 50;
xp = xp + 10;
System.out.println(xp); // 60
```

## Satu kotak hanya untuk satu tipe

```java
int age = "20"; // Error: "20" adalah teks, bukan int
```

## Aturan penamaan

| Boleh | Tidak boleh |
|---|---|
| `totalXp` | `total xp` (tidak boleh ada spasi) |
| `level2` | `2level` (tidak boleh diawali angka) |
| `userName` | `user-name` (tidak boleh ada tanda hubung) |

Nama variabel **membedakan huruf besar dan kecil**: `Age` dan `age` adalah dua variabel
yang berbeda. Gaya penulisan Java adalah **camelCase**: diawali huruf kecil, dan setiap
kata baru diawali huruf besar, seperti `totalXp`.

## Ingat

- Buat variabel dengan `tipe nama = nilai;`.
- Setelah itu, ubah nilainya dengan `nama = nilaiBaru;`.
- Variabel hanya bisa menyimpan nilai sesuai tipenya.
