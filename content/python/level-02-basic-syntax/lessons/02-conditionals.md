---
id: python-l2-conditionals
title: "Percabangan: if dan else"
order: 2
xp: 20
---

## Coba ini

```python
score = 75

if score >= 70:
    print("Lulus!")
else:
    print("Coba lagi")
```

Output:

```
Lulus!
```

## Cara kerja `if`

`if` memeriksa sebuah kondisi. Jika kondisinya `True`, kode di bawahnya dijalankan.
Jika `False`, Python menjalankan kode di bawah `else`.

| Bagian | Fungsinya |
|---|---|
| `if score >= 70:` | Kondisi yang diperiksa. Diakhiri titik dua `:`. |
| `print("Lulus!")` (menjorok 4 spasi) | Dijalankan jika kondisinya `True`. |
| `else:` | Pilihan lain jika kondisinya `False`. `else` boleh tidak ditulis. |

## Indentasi itu penting

Python memakai **indentasi** (spasi di awal baris, biasanya 4 spasi) untuk menandai
kode mana yang termasuk di dalam `if`:

```python
score = 50

if score >= 70:
    print("Lulus!")
print("Selesai")
```

Output:

```
Selesai
```

`print("Lulus!")` ada di dalam `if`, jadi tidak dijalankan. `print("Selesai")` tidak
menjorok, jadi selalu dijalankan.

Lupa memberi indentasi menyebabkan error:

```python
if score >= 70:
print("Lulus!")  # IndentationError
```

## Lebih dari dua pilihan: `elif`

```python
xp = 120

if xp >= 200:
    print("Level 3")
elif xp >= 100:
    print("Level 2")
else:
    print("Level 1")
```

Output:

```
Level 2
```

Python memeriksa kondisi dari atas ke bawah dan **hanya menjalankan bagian pertama
yang kondisinya `True`**. Sisanya dilewati.

## Hati-hati: urutan kondisi

Karena Python berhenti di kondisi pertama yang `True`, periksa kondisi yang paling
ketat lebih dulu. Pada contoh di atas, `xp >= 200` harus diperiksa sebelum `xp >= 100`.
Jika urutannya dibalik, XP 250 akan masuk ke `Level 2`.

## Ingat

- `if` menjalankan kode hanya jika kondisinya `True`.
- `else` dijalankan jika semua kondisi sebelumnya `False`.
- `elif` menambah pilihan. Hanya bagian pertama yang `True` yang dijalankan.
- Kode di dalam `if` harus menjorok (indentasi).
