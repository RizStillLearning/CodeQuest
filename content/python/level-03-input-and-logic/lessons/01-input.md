---
id: python-l3-input
title: Input dari Pengguna
order: 1
xp: 20
---

## Coba ini

```python
name = input("Siapa namamu? ")
print("Halo, " + name + "!")
```

Output, jika kamu mengetik `Budi` lalu menekan Enter:

```
Siapa namamu? Budi
Halo, Budi!
```

## Cara kerja `input()`

`input()` menampilkan pertanyaan, lalu **menunggu** pengguna mengetik sesuatu dan
menekan Enter. Apa yang diketik disimpan ke variabel.

| Kode | Fungsinya |
|---|---|
| `input("Siapa namamu? ")` | Menampilkan pertanyaan, lalu menunggu jawaban. |
| `input()` | Menunggu jawaban tanpa menampilkan pertanyaan. |

Beri spasi di akhir pertanyaan (`"Siapa namamu? "`) agar jawaban pengguna tidak menempel
pada pertanyaannya.

## Hati-hati: hasil `input()` selalu teks

Walaupun pengguna mengetik angka, `input()` selalu menghasilkan `str`. Ubah dulu dengan
`int()` atau `float()` sebelum berhitung:

```python
age = int(input("Berapa umurmu? "))
print("Tahun depan umurmu", age + 1)
```

Output, jika kamu mengetik `20`:

```
Berapa umurmu? 20
Tahun depan umurmu 21
```

Tanpa `int()`, `age + 1` menyebabkan `TypeError`, karena `"20"` adalah teks.

Jika pengguna mengetik sesuatu yang bukan angka, misalnya `dua puluh`, `int()` menyebabkan
`ValueError`. Cara menangani error seperti ini akan kamu pelajari di level selanjutnya.

## Ingat

- `input()` menunggu pengguna mengetik, lalu menekan Enter.
- Hasil `input()` selalu teks (`str`), walaupun yang diketik angka.
- Ubah ke angka dengan `int(input())` atau `float(input())`.
