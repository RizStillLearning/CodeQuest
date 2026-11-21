---
id: java-l2-loops
title: "Perulangan: for dan while"
order: 3
xp: 20
---

## Coba ini

```java
public class Main {
    public static void main(String[] args) {
        for (int i = 1; i <= 3; i++) {
            System.out.println("Soal " + i);
        }
    }
}
```

Output:

```
Soal 1
Soal 2
Soal 3
```

## Perulangan `for`

**Perulangan** menjalankan kode yang sama berkali-kali. `for` punya tiga bagian,
dipisahkan titik koma:

| Bagian | Fungsinya |
|---|---|
| `int i = 1` | Nilai awal. Dijalankan sekali, di awal. |
| `i <= 3` | Kondisi. Diperiksa sebelum setiap putaran. Jika `false`, perulangan berhenti. |
| `i++` | Langkah. Dijalankan setelah setiap putaran. |

## Berapa kali perulangannya berjalan?

| Kode | Nilai `i` | Jumlah putaran |
|---|---|---|
| `for (int i = 0; i < 3; i++)` | 0, 1, 2 | 3 kali |
| `for (int i = 0; i <= 3; i++)` | 0, 1, 2, 3 | 4 kali |
| `for (int i = 1; i <= 5; i++)` | 1, 2, 3, 4, 5 | 5 kali |

Perhatikan bedanya `<` dan `<=`: salah satu tanda ini sering membuat perulangan
berjalan satu kali terlalu banyak atau terlalu sedikit.

## Menjumlahkan dengan perulangan

```java
int totalXp = 0;
for (int i = 0; i < 5; i++) {
    totalXp += 10;
}
System.out.println(totalXp); // 50
```

## Perulangan `while`

`while` terus mengulang **selama** kondisinya `true`:

```java
int xp = 0;
while (xp < 30) {
    xp += 10;
    System.out.println(xp);
}
```

Output:

```
10
20
30
```

Setelah `xp` menjadi 30, kondisi `xp < 30` bernilai `false`, jadi perulangan berhenti.

Pakai `for` jika kamu tahu berapa kali harus mengulang. Pakai `while` jika kamu
mengulang sampai sesuatu terjadi.

## Hati-hati: perulangan tanpa akhir

Jika nilai di dalam kondisi tidak pernah berubah, `while` tidak akan pernah berhenti:

```java
int xp = 0;
while (xp < 30) {
    System.out.println(xp); // lupa menambah xp: perulangan ini tidak pernah berhenti!
}
```

Pastikan ada baris di dalam perulangan yang membuat kondisinya suatu saat menjadi `false`.

## Ingat

- `for (awal; kondisi; langkah)` mengulang selama kondisinya `true`.
- `i < 3` berjalan 3 kali (dari 0), `i <= 3` berjalan 4 kali.
- `while` mengulang selama kondisinya `true`.
- Pastikan kondisi `while` suatu saat menjadi `false`.
