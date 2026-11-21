---
id: python-l2-operators
title: Operator
order: 1
xp: 20
---

## Coba ini

```python
xp = 45
bonus = 10
total = xp + bonus

print(total)
print(total > 50)
print(total % 2 == 0)
```

Output:

```
55
True
False
```

## Operator aritmetika

Operator aritmetika dipakai untuk berhitung.

| Operator | Arti | Contoh | Hasil |
|---|---|---|---|
| `+` | tambah | `7 + 2` | `9` |
| `-` | kurang | `7 - 2` | `5` |
| `*` | kali | `7 * 2` | `14` |
| `/` | bagi | `7 / 2` | `3.5` |
| `//` | bagi, dibulatkan ke bawah | `7 // 2` | `3` |
| `%` | sisa bagi (modulo) | `7 % 2` | `1` |
| `**` | pangkat | `2 ** 3` | `8` |

Di Python, `/` selalu menghasilkan `float`, walaupun hasilnya bulat: `6 / 2` menghasilkan `3.0`.

`%` sering dipakai untuk mengecek bilangan genap: jika `angka % 2` hasilnya `0`, angkanya genap.

Seperti di matematika, `*` dan `/` dihitung lebih dulu daripada `+` dan `-`.
Pakai tanda kurung untuk mengubah urutannya:

```python
print(2 + 3 * 4)    # 14
print((2 + 3) * 4)  # 20
```

## Cara singkat mengubah nilai

| Ditulis singkat | Sama dengan |
|---|---|
| `xp += 10` | `xp = xp + 10` |
| `xp -= 5` | `xp = xp - 5` |
| `xp *= 2` | `xp = xp * 2` |

## Operator perbandingan

Operator perbandingan membandingkan dua nilai. Hasilnya selalu `bool`: `True` atau `False`.

| Operator | Arti | Contoh | Hasil |
|---|---|---|---|
| `==` | sama dengan | `5 == 5` | `True` |
| `!=` | tidak sama dengan | `5 != 3` | `True` |
| `>` | lebih besar dari | `7 > 10` | `False` |
| `<` | lebih kecil dari | `3 < 5` | `True` |
| `>=` | lebih besar atau sama dengan | `5 >= 5` | `True` |
| `<=` | lebih kecil atau sama dengan | `4 <= 3` | `False` |

Jangan tertukar: `=` **menyimpan** nilai, sedangkan `==` **membandingkan** dua nilai.

## Operator logika

Operator logika menggabungkan beberapa kondisi.

| Operator | Hasilnya `True` jika... | Contoh | Hasil |
|---|---|---|---|
| `and` | kedua kondisi `True` | `True and False` | `False` |
| `or` | salah satu kondisi `True` | `True or False` | `True` |
| `not` | kondisinya `False` (membalik nilai) | `not True` | `False` |

```python
score = 85
finished = True
print(score >= 70 and finished)  # True
```

## Ingat

- `/` menghasilkan desimal, `//` membulatkan ke bawah, dan `%` memberi sisa bagi.
- `xp += 10` adalah cara singkat menulis `xp = xp + 10`.
- Perbandingan (`==`, `>`, `<=`, ...) selalu menghasilkan `True` atau `False`.
- `and` butuh kedua kondisi benar, `or` cukup salah satu.
