---
id: python-l4-scope
title: Cakupan Variabel (Scope)
order: 3
xp: 20
---

## Coba ini

```python
def level_up():
    level = 2
    print("Di dalam fungsi:", level)

level = 1
level_up()
print("Di luar fungsi:", level)
```

Output:

```
Di dalam fungsi: 2
Di luar fungsi: 1
```

## Variabel lokal

Variabel yang dibuat di dalam fungsi disebut **variabel lokal**. Variabel ini hanya ada
di dalam fungsi tersebut.

Pada contoh di atas, `level` di dalam fungsi adalah kotak yang **berbeda** dari `level`
di luar fungsi, walaupun namanya sama. Mengubah yang satu tidak mengubah yang lain.

Variabel lokal juga hilang setelah fungsinya selesai, jadi tidak bisa dipakai di luar:

```python
def calculate():
    result = 10 * 5

calculate()
print(result)  # NameError: result tidak dikenal di luar fungsi
```

## Hati-hati: mengubah parameter tidak mengubah variabel aslinya

```python
def add_bonus(xp):
    xp = xp + 10

my_xp = 50
add_bonus(my_xp)
print(my_xp)  # 50, bukan 60
```

Parameter `xp` hanya menerima **salinan nilai** 50. Mengubah `xp` di dalam fungsi tidak
mengubah `my_xp`.

## Cara yang benar: kembalikan nilainya

```python
def add_bonus(xp):
    return xp + 10

my_xp = 50
my_xp = add_bonus(my_xp)
print(my_xp)  # 60
```

Fungsi mengembalikan nilai baru dengan `return`, lalu hasilnya disimpan lagi ke `my_xp`.

Python juga punya kata kunci `global` untuk mengubah variabel di luar fungsi, tetapi
sebaiknya hindari. Kode yang memakai `return` lebih mudah dibaca dan diperiksa.

## Ingat

- Variabel yang dibuat di dalam fungsi hanya ada di dalam fungsi itu.
- Variabel dengan nama sama di dalam dan di luar fungsi adalah dua kotak yang berbeda.
- Mengubah parameter tidak mengubah variabel yang dikirim.
- Untuk mengubah nilai, `return` nilai barunya lalu simpan: `my_xp = add_bonus(my_xp)`.
