---
id: c-l4-parameters-return
title: Parameter dan return
order: 2
xp: 20
---

## Coba ini

```c
int add_xp(int xp, int bonus) {
    return xp + bonus;
}

int main(void) {
    int total = add_xp(50, 10);
    printf("%d\n", total);
    return 0;
}
```

Output:

```
60
```

## Parameter: mengirim data ke fungsi

**Parameter** adalah variabel yang menerima nilai saat fungsi dipanggil. Nilai yang
dikirim disebut **argumen**. Di C, setiap parameter ditulis dengan tipenya: `int xp, int bonus`.

| Pemanggilan | `xp` | `bonus` |
|---|---|---|
| `add_xp(50, 10)` | 50 | 10 |
| `add_xp(10, 50)` | 10 | 50 |

Argumen dimasukkan ke parameter **sesuai urutannya**, dan jumlahnya harus sama:
`add_xp(50)` menyebabkan error saat compile.

## `return`: mengembalikan hasil

Kata sebelum nama fungsi adalah **tipe hasilnya** (return type):

| Return type | Artinya |
|---|---|
| `void` | tidak mengembalikan nilai |
| `int` | mengembalikan bilangan bulat |
| `double` | mengembalikan bilangan desimal |
| `char` | mengembalikan satu karakter |

`return` mengirim nilai kembali ke tempat fungsi dipanggil, dan **langsung menghentikan fungsi**:

```c
char get_grade(int score) {
    if (score >= 80) {
        return 'A';
    } else if (score >= 60) {
        return 'B';
    }
    return 'C';
}

int main(void) {
    printf("%c\n", get_grade(85));
    printf("%c\n", get_grade(70));
    printf("%c\n", get_grade(40));
    return 0;
}
```

Output:

```
A
B
C
```

Itulah arti `return 0;` di akhir `main`: `main` mengembalikan `int` 0 untuk memberi tahu
bahwa program selesai dengan sukses.

## Hati-hati: lupa `return`

Jika fungsi bukan `void` tetapi ada jalur yang tidak berakhir dengan `return`, C tetap
mau meng-compile kodenya (paling-paling dengan peringatan). Tetapi hasil fungsinya menjadi
**nilai acak** yang tidak bisa ditebak. Pastikan setiap jalur berakhir dengan `return`.

## Hati-hati: `printf` bukan `return`

```c
void double_it(int number) {
    printf("%d\n", number * 2);
}

int main(void) {
    int result = double_it(5); // Error: fungsi void tidak menghasilkan nilai
    return 0;
}
```

`printf` hanya **menampilkan** nilai di layar. Jika hasilnya akan dipakai, ganti `void`
menjadi `int` dan pakai `return number * 2;`.

## Ingat

- Setiap parameter ditulis dengan tipenya, dan argumen dimasukkan sesuai urutan.
- Return type menentukan jenis nilai yang dikembalikan. `void` berarti tidak ada.
- `return` mengembalikan hasil dan langsung menghentikan fungsi.
- Jika bukan `void`, setiap jalur kode harus berakhir dengan `return`.
