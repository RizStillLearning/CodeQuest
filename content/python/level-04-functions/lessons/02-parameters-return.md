---
id: python-l4-parameters-return
title: Parameter dan return
order: 2
xp: 20
---

## Coba ini

```python
def add_xp(xp, bonus):
    return xp + bonus

total = add_xp(50, 10)
print(total)
```

Output:

```
60
```

## Parameter: mengirim data ke fungsi

**Parameter** adalah variabel yang menerima nilai saat fungsi dipanggil. Nilai yang
dikirim disebut **argumen**.

| Pemanggilan | `xp` | `bonus` |
|---|---|---|
| `add_xp(50, 10)` | 50 | 10 |
| `add_xp(10, 50)` | 10 | 50 |

Argumen dimasukkan ke parameter **sesuai urutannya**: argumen pertama ke parameter
pertama, dan seterusnya. Jumlahnya juga harus sama: `add_xp(50)` menyebabkan `TypeError`
karena `bonus` tidak diberi nilai.

## `return`: mengembalikan hasil

`return` mengirim nilai kembali ke tempat fungsi dipanggil. Nilai itu bisa disimpan
ke variabel, ditampilkan, atau dipakai untuk menghitung.

`return` juga **langsung menghentikan fungsi**. Kode setelah `return` tidak dijalankan:

```python
def get_grade(score):
    if score >= 80:
        return "A"
    elif score >= 60:
        return "B"
    return "C"

print(get_grade(85))
print(get_grade(70))
print(get_grade(40))
```

Output:

```
A
B
C
```

## Hati-hati: `print` bukan `return`

```python
def double(number):
    print(number * 2)

result = double(5)
print(result)
```

Output:

```
10
None
```

`print()` hanya **menampilkan** nilai di layar. Fungsi ini tidak punya `return`, jadi
hasilnya adalah `None` (artinya "tidak ada nilai"). Jika kamu ingin memakai hasilnya,
misalnya untuk dijumlahkan, pakai `return number * 2`.

## Ingat

- Parameter menerima nilai (argumen) sesuai urutan saat fungsi dipanggil.
- `return` mengembalikan hasil dan langsung menghentikan fungsi.
- Fungsi tanpa `return` menghasilkan `None`.
- Pakai `return` jika hasilnya akan dipakai lagi. `print` hanya menampilkan.
