---
id: c-l2-operators
title: Operator
order: 1
xp: 20
---

## Coba ini

```c
#include <stdio.h>

int main(void) {
    int xp = 45;
    int bonus = 10;
    int total = xp + bonus;

    printf("%d\n", total);
    printf("%d\n", total > 50);
    printf("%d\n", total % 2 == 0);
    return 0;
}
```

Output:

```
55
1
0
```

Di C, hasil perbandingan adalah angka: `1` berarti benar, `0` berarti salah.

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

```c
printf("%d\n", 2 + 3 * 4);   // 14
printf("%d\n", (2 + 3) * 4); // 20
```

## Cara singkat mengubah nilai

| Ditulis singkat | Sama dengan |
|---|---|
| `xp += 10;` | `xp = xp + 10;` |
| `xp -= 5;` | `xp = xp - 5;` |
| `xp++;` | `xp = xp + 1;` |
| `xp--;` | `xp = xp - 1;` |

## Operator perbandingan

Operator perbandingan membandingkan dua nilai. Hasilnya `1` (benar) atau `0` (salah).

| Operator | Arti | Contoh | Hasil |
|---|---|---|---|
| `==` | sama dengan | `5 == 5` | `1` |
| `!=` | tidak sama dengan | `5 != 3` | `1` |
| `>` | lebih besar dari | `7 > 10` | `0` |
| `<` | lebih kecil dari | `3 < 5` | `1` |
| `>=` | lebih besar atau sama dengan | `5 >= 5` | `1` |
| `<=` | lebih kecil atau sama dengan | `4 <= 3` | `0` |

Jangan tertukar: `=` **menyimpan** nilai, sedangkan `==` **membandingkan** dua nilai.

## Operator logika

Operator logika menggabungkan beberapa kondisi.

| Operator | Arti | Hasilnya benar jika... | Contoh | Hasil |
|---|---|---|---|---|
| `&&` | dan | kedua kondisi benar | `1 && 0` | `0` |
| `\|\|` | atau | salah satu kondisi benar | `1 \|\| 0` | `1` |
| `!` | bukan | kondisinya salah (membalik nilai) | `!1` | `0` |

```c
int score = 85;
int finished = 1;
printf("%d\n", score >= 70 && finished); // 1
```

## Ingat

- `%` memberi sisa bagi, dan `int / int` membuang desimal.
- `xp += 10;` dan `xp++;` adalah cara singkat mengubah nilai.
- Perbandingan menghasilkan `1` (benar) atau `0` (salah).
- `&&` butuh kedua kondisi benar, `||` cukup salah satu.
