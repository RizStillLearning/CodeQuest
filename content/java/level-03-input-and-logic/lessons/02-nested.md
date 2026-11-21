---
id: java-l3-nested
title: Kondisi dan Perulangan Bersarang
order: 2
xp: 20
---

## Coba ini

```java
public class Main {
    public static void main(String[] args) {
        int score = 85;
        boolean finished = true;

        if (finished) {
            if (score >= 80) {
                System.out.println("Lulus dengan nilai A");
            } else {
                System.out.println("Lulus");
            }
        } else {
            System.out.println("Kuis belum selesai");
        }
    }
}
```

Output:

```
Lulus dengan nilai A
```

## `if` di dalam `if`

`if` bisa ditulis di dalam `if` lain. Ini disebut **kondisi bersarang** (nested).
`if` bagian dalam hanya diperiksa jika `if` bagian luar bernilai `true`.

| `finished` | `score` | Output |
|---|---|---|
| `true` | `85` | Lulus dengan nilai A |
| `true` | `70` | Lulus |
| `false` | berapa pun | Kuis belum selesai |

Pastikan setiap `{` punya pasangan `}`. Indentasi yang rapi membantu kamu melihat
`}` mana yang menutup `if` mana.

Kadang `if` bersarang bisa diganti dengan `&&`:

```java
int score = 85;
boolean finished = true;

if (finished && score >= 80) {
    System.out.println("Lulus dengan nilai A");
}
```

Pakai `&&` jika kamu hanya butuh satu pilihan. Pakai `if` bersarang jika setiap
kondisi punya pilihan `else` sendiri, seperti pada contoh pertama.

## Perulangan di dalam perulangan

```java
for (int level = 1; level <= 2; level++) {
    for (int question = 1; question <= 3; question++) {
        System.out.println("Level " + level + " - Soal " + question);
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
Perulangan luar berjalan 2 kali dan perulangan dalam 3 kali, jadi `println` dijalankan
2 × 3 = 6 kali.

## Ingat

- `if` di dalam `if` hanya diperiksa jika `if` luarnya `true`.
- Setiap `{` harus punya pasangan `}`.
- Pada perulangan bersarang, perulangan dalam berjalan sampai selesai untuk setiap putaran luar.
- Jumlah putaran total = putaran luar × putaran dalam.
