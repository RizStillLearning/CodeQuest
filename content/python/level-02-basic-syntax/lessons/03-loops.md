---
id: python-l2-loops
title: "Perulangan: for dan while"
order: 3
xp: 20
---

## Coba ini

```python
for i in range(1, 4):
    print("Soal", i)
```

Output:

```
Soal 1
Soal 2
Soal 3
```

## Perulangan `for`

**Perulangan** menjalankan kode yang sama berkali-kali. `for` mengulang kode untuk
setiap angka dari `range()`. Di setiap putaran, `i` berisi angka berikutnya.

Seperti `if`, kode yang diulang harus menjorok (indentasi).

## `range()`

| Kode | Angka yang dihasilkan |
|---|---|
| `range(5)` | 0, 1, 2, 3, 4 |
| `range(1, 6)` | 1, 2, 3, 4, 5 |
| `range(0, 10, 2)` | 0, 2, 4, 6, 8 |

Angka terakhir **tidak ikut**: `range(1, 6)` berhenti di 5, bukan 6.
`range(5)` dimulai dari 0 dan menghasilkan 5 angka.

## Menjumlahkan dengan perulangan

```python
total_xp = 0
for i in range(5):
    total_xp += 10
print(total_xp)  # 50
```

Kodenya diulang 5 kali, dan setiap putaran menambah 10.

## Perulangan `while`

`while` terus mengulang **selama** kondisinya `True`:

```python
xp = 0
while xp < 30:
    xp += 10
    print(xp)
```

Output:

```
10
20
30
```

Setelah `xp` menjadi 30, kondisi `xp < 30` bernilai `False`, jadi perulangan berhenti.

Pakai `for` jika kamu tahu berapa kali harus mengulang. Pakai `while` jika kamu
mengulang sampai sesuatu terjadi.

## Hati-hati: perulangan tanpa akhir

Jika nilai di dalam kondisi tidak pernah berubah, `while` tidak akan pernah berhenti:

```python
xp = 0
while xp < 30:
    print(xp)  # lupa menambah xp: perulangan ini tidak pernah berhenti!
```

Pastikan ada baris di dalam perulangan yang membuat kondisinya suatu saat menjadi `False`.

## Ingat

- `for i in range(...)` mengulang kode untuk setiap angka.
- `range(a, b)` dimulai dari `a` dan berhenti sebelum `b`.
- `while` mengulang selama kondisinya `True`.
- Pastikan kondisi `while` suatu saat menjadi `False`.
