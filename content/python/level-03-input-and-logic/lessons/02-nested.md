---
id: python-l3-nested
title: Kondisi dan Perulangan Bersarang
order: 2
xp: 20
---

## Coba ini

```python
score = 85
finished = True

if finished:
    if score >= 80:
        print("Lulus dengan nilai A")
    else:
        print("Lulus")
else:
    print("Kuis belum selesai")
```

Output:

```
Lulus dengan nilai A
```

## `if` di dalam `if`

`if` bisa ditulis di dalam `if` lain. Ini disebut **kondisi bersarang** (nested).
`if` bagian dalam hanya diperiksa jika `if` bagian luar bernilai `True`.

Setiap tingkat bersarang menjorok 4 spasi lebih dalam.

| `finished` | `score` | Output |
|---|---|---|
| `True` | `85` | Lulus dengan nilai A |
| `True` | `70` | Lulus |
| `False` | berapa pun | Kuis belum selesai |

Kadang `if` bersarang bisa diganti dengan `and`:

```python
score = 85
finished = True

if finished and score >= 80:
    print("Lulus dengan nilai A")
```

Pakai `and` jika kamu hanya butuh satu pilihan. Pakai `if` bersarang jika setiap
kondisi punya pilihan `else` sendiri, seperti pada contoh pertama.

## Perulangan di dalam perulangan

```python
for level in range(1, 3):
    for question in range(1, 4):
        print("Level", level, "- Soal", question)
```

Output:

```
Level 1 - Soal 1
Level 1 - Soal 2
Level 1 - Soal 3
Level 2 - Soal 1
Level 2 - Soal 2
Level 2 - Soal 3
```

Untuk setiap putaran perulangan luar, perulangan dalam berjalan **sampai selesai**.
Perulangan luar berjalan 2 kali dan perulangan dalam 3 kali, jadi `print` dijalankan
2 × 3 = 6 kali.

## Ingat

- `if` di dalam `if` hanya diperiksa jika `if` luarnya `True`.
- Setiap tingkat bersarang menambah 4 spasi indentasi.
- Pada perulangan bersarang, perulangan dalam berjalan sampai selesai untuk setiap putaran luar.
- Jumlah putaran total = putaran luar × putaran dalam.
