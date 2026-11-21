---
id: python-l3-break-continue
title: break dan continue
order: 3
xp: 20
---

## Coba ini

```python
for i in range(1, 6):
    if i == 4:
        break
    print(i)
print("Selesai")
```

Output:

```
1
2
3
Selesai
```

## `break`: hentikan perulangan

`break` langsung menghentikan perulangan, walaupun masih ada putaran yang tersisa.
Program lalu lanjut ke kode setelah perulangan.

Pada contoh di atas, saat `i` menjadi 4, `break` dijalankan. Angka 4 dan 5 tidak
pernah ditampilkan, tetapi `print("Selesai")` tetap dijalankan.

## `continue`: lewati putaran ini

`continue` melompati sisa kode di putaran ini, lalu lanjut ke putaran berikutnya:

```python
for i in range(1, 6):
    if i == 3:
        continue
    print(i)
```

Output:

```
1
2
4
5
```

| | `break` | `continue` |
|---|---|---|
| Apa yang terjadi | perulangan berhenti | sisa putaran ini dilewati |
| Perulangannya lanjut? | tidak | ya, ke putaran berikutnya |

## Ulangi sampai benar: `while True`

```python
while True:
    answer = input("Berapa 2 + 2? ")
    if answer == "4":
        print("Benar!")
        break
    print("Salah, coba lagi.")
```

Output, jika kamu mengetik `5`, lalu `4`:

```
Berapa 2 + 2? 5
Salah, coba lagi.
Berapa 2 + 2? 4
Benar!
```

Kondisi `while True` selalu `True`, jadi perulangan ini hanya bisa berhenti dengan `break`.
Pola ini cocok untuk mengulang pertanyaan sampai jawabannya benar.

`answer` dibandingkan dengan `"4"` (teks), karena hasil `input()` adalah teks.

## Ingat

- `break` menghentikan perulangan.
- `continue` melompati sisa putaran ini, lalu lanjut ke putaran berikutnya.
- `while True` berulang terus sampai bertemu `break`.
