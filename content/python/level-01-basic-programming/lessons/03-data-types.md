---
id: python-l1-data-types
title: Tipe Data
order: 3
xp: 20
---

## Coba ini

```python
age = 20
height = 1.75
name = "Siti"
is_student = True

print(type(age))
print(type(height))
print(type(name))
print(type(is_student))
```

Output:

```
<class 'int'>
<class 'float'>
<class 'str'>
<class 'bool'>
```

## Empat tipe data dasar

| Tipe | Isinya | Contoh |
|---|---|---|
| `int` | bilangan bulat | `20`, `-3`, `0` |
| `float` | bilangan desimal | `1.75`, `3.0` |
| `str` | teks (rangkaian karakter, disebut juga "string") | `"Siti"`, `"20"` |
| `bool` | benar atau salah | `True`, `False` |

`type()` memberi tahu tipe dari sebuah nilai.

Di kode, angka desimal ditulis dengan **titik**, bukan koma: `1.75`, bukan `1,75`.

## Hati-hati: `"20"` bukan `20`

Tanda kutip mengubah apa pun menjadi teks. `"20"` adalah `str`, bukan angka.

```python
print(5 + 5)      # 10
print("5" + "5")  # 55 (teksnya disambung)
```

Mencampur teks dan angka dengan `+` menyebabkan error:

```python
print("5" + 5)  # TypeError
```

## Mengubah tipe

| Fungsi | Mengubah ke | Contoh | Hasil |
|---|---|---|---|
| `int()` | `int` | `int("5")` | `5` |
| `float()` | `float` | `float("2.5")` | `2.5` |
| `str()` | `str` | `str(20)` | `"20"` |

```python
level = 3
print("Level " + str(level))  # Level 3
```

## Ingat

- `int`, `float`, `str`, dan `bool` adalah tipe data dasar.
- Tanda kutip membuat nilai menjadi teks, walaupun isinya terlihat seperti angka.
- Ubah tipe dengan `int()`, `float()`, dan `str()`.
