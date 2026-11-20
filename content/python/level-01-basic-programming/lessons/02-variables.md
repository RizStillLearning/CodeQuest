---
id: python-l1-variables
title: Variabel
order: 2
xp: 20
---

## Coba ini

```python
name = "Budi"
age = 20
print(name)
print(age)
```

Output:

```
Budi
20
```

## Apa itu variabel?

**Variabel** adalah kotak berlabel yang menyimpan sebuah nilai. `name = "Budi"` artinya:
buat kotak bernama `name`, lalu masukkan `"Budi"` ke dalamnya.

Tanda `=` artinya **"simpan nilai ini"**, bukan "sama dengan".

## Mengubah nilai

Variabel bisa diberi nilai baru. Nilai lama akan diganti.

```python
score = 10
score = 15
print(score)  # 15
```

Kamu bisa memakai nilai variabel saat ini untuk menghitung nilai barunya:

```python
xp = 50
xp = xp + 10
print(xp)  # 60
```

## Aturan penamaan

| Boleh | Tidak boleh |
|---|---|
| `total_xp` | `total xp` (tidak boleh ada spasi) |
| `level2` | `2level` (tidak boleh diawali angka) |
| `user_name` | `user-name` (tidak boleh ada tanda hubung) |

Nama variabel **membedakan huruf besar dan kecil**: `Age` dan `age` adalah dua variabel
yang berbeda. Gaya penulisan Python memakai huruf kecil yang disambung dengan `_`,
seperti `total_xp`.

## Ingat

- `=` menyimpan nilai ke dalam variabel.
- Nilai baru menggantikan nilai lama.
- Nama variabel tidak boleh mengandung spasi atau diawali angka.
