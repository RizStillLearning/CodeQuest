---
id: c-l3-nested
title: Kondisi dan Perulangan Bersarang
order: 2
xp: 20
---

## Coba ini

```c
#include <stdio.h>

int main(void) {
    int score = 85;
    int finished = 1;

    if (finished) {
        if (score >= 80) {
            printf("Lulus dengan nilai A\n");
        } else {
            printf("Lulus\n");
        }
    } else {
        printf("Kuis belum selesai\n");
    }
    return 0;
}
```

Output:

```
Lulus dengan nilai A
```

## `if` di dalam `if`

`if` bisa ditulis di dalam `if` lain. Ini disebut **kondisi bersarang** (nested).
`if` bagian dalam hanya diperiksa jika `if` bagian luar bernilai benar.

`if (finished)` artinya "jika `finished` bukan 0". Di sini `finished` bernilai 1, jadi benar.

| `finished` | `score` | Output |
|---|---|---|
| `1` | `85` | Lulus dengan nilai A |
| `1` | `70` | Lulus |
| `0` | berapa pun | Kuis belum selesai |

Pastikan setiap `{` punya pasangan `}`. Indentasi yang rapi membantu kamu melihat
`}` mana yang menutup `if` mana.

Kadang `if` bersarang bisa diganti dengan `&&`:

```c
int score = 85;
int finished = 1;

if (finished && score >= 80) {
    printf("Lulus dengan nilai A\n");
}
```

Pakai `&&` jika kamu hanya butuh satu pilihan. Pakai `if` bersarang jika setiap
kondisi punya pilihan `else` sendiri, seperti pada contoh pertama.

## Perulangan di dalam perulangan

```c
for (int level = 1; level <= 2; level++) {
    for (int question = 1; question <= 3; question++) {
        printf("Level %d - Soal %d\n", level, question);
    }
}
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
Perulangan luar berjalan 2 kali dan perulangan dalam 3 kali, jadi `printf` dijalankan
2 × 3 = 6 kali.

## Ingat

- `if` di dalam `if` hanya diperiksa jika `if` luarnya benar.
- Setiap `{` harus punya pasangan `}`.
- Pada perulangan bersarang, perulangan dalam berjalan sampai selesai untuk setiap putaran luar.
- Jumlah putaran total = putaran luar × putaran dalam.
