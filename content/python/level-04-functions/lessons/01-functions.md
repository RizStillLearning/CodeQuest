---
id: python-l4-functions
title: Membuat Fungsi
order: 1
xp: 20
---

## Coba ini

```python
def greet():
    print("Halo!")
    print("Selamat belajar di CodeQuest.")

greet()
greet()
```

Output:

```
Halo!
Selamat belajar di CodeQuest.
Halo!
Selamat belajar di CodeQuest.
```

## Apa itu fungsi?

**Fungsi** adalah sekumpulan kode yang diberi nama. Setelah dibuat, fungsi bisa
**dipanggil** berkali-kali tanpa perlu menulis ulang kodenya.

| Bagian | Fungsinya |
|---|---|
| `def greet():` | Membuat (mendefinisikan) fungsi bernama `greet`. Diakhiri titik dua `:`. |
| kode yang menjorok di bawahnya | Isi fungsi, yang dijalankan setiap kali fungsinya dipanggil. |
| `greet()` | Memanggil fungsi. Jangan lupa tanda kurungnya. |

Kamu sebenarnya sudah memakai fungsi sejak Level 1: `print()`, `input()`, `int()`,
`type()`, dan `range()` adalah fungsi bawaan Python.

## Alur program saat fungsi dipanggil

```python
def greet():
    print("Halo!")

print("Mulai")
greet()
print("Selesai")
```

Output:

```
Mulai
Halo!
Selesai
```

Membuat fungsi dengan `def` **tidak menjalankannya**. Python baru menjalankan isi fungsi
saat fungsinya dipanggil, lalu kembali ke baris setelah pemanggilan.

## Hati-hati: buat fungsinya dulu, baru panggil

```python
greet()  # NameError: greet belum dibuat

def greet():
    print("Halo!")
```

Python membaca kode dari atas ke bawah, jadi fungsi harus dibuat sebelum dipanggil.

Nama fungsi mengikuti aturan yang sama seperti nama variabel. Biasakan memakai kata kerja,
seperti `show_score` atau `add_xp`.

## Ingat

- `def nama():` membuat fungsi. Isinya ditulis menjorok di bawahnya.
- `nama()` memanggil fungsi, dan isinya dijalankan setiap kali dipanggil.
- Buat fungsi sebelum memanggilnya.
