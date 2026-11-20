---
id: c-l1-data-types
title: Tipe Data
order: 3
xp: 20
---

## Coba ini

```c
#include <stdio.h>
#include <stdbool.h>

int main(void) {
    int age = 20;
    double height = 1.75;
    char grade = 'A';
    char name[] = "Siti";
    bool is_student = true;

    printf("%d\n", age);
    printf("%.2f\n", height);
    printf("%c\n", grade);
    printf("%s\n", name);
    printf("%d\n", is_student);
    return 0;
}
```

Output:

```
20
1.75
A
Siti
1
```

## Tipe data dasar

| Tipe | Isinya | Contoh | Ditampilkan dengan |
|---|---|---|---|
| `int` | bilangan bulat | `int age = 20;` | `%d` |
| `double` | bilangan desimal | `double height = 1.75;` | `%f` |
| `char` | satu karakter, diapit tanda kutip satu | `char grade = 'A';` | `%c` |
| teks | deretan `char`, diapit tanda kutip dua | `char name[] = "Siti";` | `%s` |
| `bool` | benar atau salah (butuh `#include <stdbool.h>`) | `bool is_student = true;` | `%d` (menampilkan `1` atau `0`) |

Di kode, angka desimal ditulis dengan **titik**, bukan koma: `1.75`, bukan `1,75`.

## Mengatur jumlah angka desimal

`%f` menampilkan 6 angka di belakang titik. Tambahkan `.2` untuk menampilkan 2 angka saja:

```c
double price = 2.5;
printf("%f\n", price);   // 2.500000
printf("%.2f\n", price); // 2.50
```

## Hati-hati: membagi dua `int`

Jika kedua angka bertipe `int`, C membuang bagian desimalnya:

```c
printf("%d\n", 7 / 2);     // 3
printf("%.1f\n", 7.0 / 2); // 3.5
```

Untuk membagi dua variabel `int` dengan hasil desimal, ubah salah satunya menjadi `double` dulu:

```c
int total = 7;
int count = 2;
printf("%.1f\n", (double) total / count); // 3.5
```

## Ingat

- `int`, `double`, `char`, dan `bool` adalah tipe data dasar. Teks disimpan sebagai `char name[]`.
- Setiap tipe punya placeholder `printf` sendiri: `%d`, `%f`, `%c`, `%s`.
- `int / int` menghasilkan `int`: bagian desimalnya dibuang.
