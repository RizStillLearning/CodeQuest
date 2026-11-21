---
id: java-l2-operators
title: Operator
order: 1
xp: 20
---

## Coba ini

```java
public class Main {
    public static void main(String[] args) {
        int xp = 45;
        int bonus = 10;
        int total = xp + bonus;

        System.out.println(total);
        System.out.println(total > 50);
        System.out.println(total % 2 == 0);
    }
}
```

Output:

```
55
true
false
```

## Operator aritmetika

Operator aritmetika dipakai untuk berhitung.

| Operator | Arti | Contoh | Hasil |
|---|---|---|---|
| `+` | tambah | `7 + 2` | `9` |
| `-` | kurang | `7 - 2` | `5` |
| `*` | kali | `7 * 2` | `14` |
| `/` | bagi | `7 / 2` | `3` (dua `int`, desimal dibuang) |
| `%` | sisa bagi (modulo) | `7 % 2` | `1` |

`%` sering dipakai untuk mengecek bilangan genap: jika `number % 2` hasilnya `0`, angkanya genap.

Seperti di matematika, `*`, `/`, dan `%` dihitung lebih dulu daripada `+` dan `-`.
Pakai tanda kurung untuk mengubah urutannya:

```java
System.out.println(2 + 3 * 4);   // 14
System.out.println((2 + 3) * 4); // 20
```

## Cara singkat mengubah nilai

| Ditulis singkat | Sama dengan |
|---|---|
| `xp += 10;` | `xp = xp + 10;` |
| `xp -= 5;` | `xp = xp - 5;` |
| `xp++;` | `xp = xp + 1;` |
| `xp--;` | `xp = xp - 1;` |

## Operator perbandingan

Operator perbandingan membandingkan dua nilai. Hasilnya selalu `boolean`: `true` atau `false`.

| Operator | Arti | Contoh | Hasil |
|---|---|---|---|
| `==` | sama dengan | `5 == 5` | `true` |
| `!=` | tidak sama dengan | `5 != 3` | `true` |
| `>` | lebih besar dari | `7 > 10` | `false` |
| `<` | lebih kecil dari | `3 < 5` | `true` |
| `>=` | lebih besar atau sama dengan | `5 >= 5` | `true` |
| `<=` | lebih kecil atau sama dengan | `4 <= 3` | `false` |

Jangan tertukar: `=` **menyimpan** nilai, sedangkan `==` **membandingkan** dua nilai.

## Operator logika

Operator logika menggabungkan beberapa kondisi.

| Operator | Arti | Hasilnya `true` jika... | Contoh | Hasil |
|---|---|---|---|---|
| `&&` | dan | kedua kondisi `true` | `true && false` | `false` |
| `\|\|` | atau | salah satu kondisi `true` | `true \|\| false` | `true` |
| `!` | bukan | kondisinya `false` (membalik nilai) | `!true` | `false` |

```java
int score = 85;
boolean finished = true;
System.out.println(score >= 70 && finished); // true
```

## Membandingkan `String`

Untuk `String`, pakai `.equals()`, bukan `==`:

```java
String name = "Budi";
System.out.println(name.equals("Budi")); // true
```

`==` memeriksa apakah dua `String` adalah objek yang sama, bukan apakah isinya sama,
jadi hasilnya bisa salah.

## Ingat

- `%` memberi sisa bagi, dan `int / int` membuang desimal.
- `xp += 10;` dan `xp++;` adalah cara singkat mengubah nilai.
- Perbandingan (`==`, `>`, `<=`, ...) selalu menghasilkan `true` atau `false`.
- `&&` butuh kedua kondisi benar, `||` cukup salah satu.
- Bandingkan `String` dengan `.equals()`.
