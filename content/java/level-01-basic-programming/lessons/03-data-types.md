---
id: java-l1-data-types
title: Tipe Data
order: 3
xp: 20
---

## Coba ini

```java
public class Main {
    public static void main(String[] args) {
        int age = 20;
        double height = 1.75;
        String name = "Siti";
        boolean isStudent = true;
        char grade = 'A';

        System.out.println(age);
        System.out.println(height);
        System.out.println(name);
        System.out.println(isStudent);
        System.out.println(grade);
    }
}
```

Output:

```
20
1.75
Siti
true
A
```

## Tipe data dasar

| Tipe | Isinya | Contoh |
|---|---|---|
| `int` | bilangan bulat | `20`, `-3`, `0` |
| `double` | bilangan desimal | `1.75`, `3.0` |
| `String` | teks, diapit tanda kutip dua | `"Siti"`, `"20"` |
| `boolean` | benar atau salah | `true`, `false` |
| `char` | satu karakter, diapit tanda kutip satu | `'A'`, `'7'` |

`String` diawali huruf kapital **S**. Tipe lainnya ditulis dengan huruf kecil semua.

Di kode, angka desimal ditulis dengan **titik**, bukan koma: `1.75`, bukan `1,75`.

## Hati-hati: membagi dua `int`

Jika kedua angka bertipe `int`, Java membuang bagian desimalnya:

```java
System.out.println(7 / 2);   // 3
System.out.println(7.0 / 2); // 3.5
```

## Hati-hati: `+` dengan teks

Jika salah satu sisi `+` adalah `String`, Java menyambungnya sebagai teks:

```java
System.out.println("Level " + 3); // Level 3
System.out.println("5" + 5);      // 55
```

## Mengubah tipe

| Kode | Hasil | Fungsinya |
|---|---|---|
| `Integer.parseInt("5")` | `5` | Teks ke `int` |
| `Double.parseDouble("2.5")` | `2.5` | Teks ke `double` |
| `String.valueOf(20)` | `"20"` | Angka ke teks |
| `(int) 3.9` | `3` | `double` ke `int` (bagian desimal dibuang) |

## Ingat

- `int`, `double`, `String`, `boolean`, dan `char` adalah tipe data dasar.
- `int / int` menghasilkan `int`: bagian desimalnya dibuang.
- `+` dengan `String` menyambung teks, bukan menjumlahkan angka.
