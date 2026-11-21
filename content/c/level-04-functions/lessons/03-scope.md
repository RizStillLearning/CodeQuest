---
id: c-l4-scope
title: Cakupan Variabel (Scope)
order: 3
xp: 20
---

## Coba ini

```c
void level_up(void) {
    int level = 2;
    printf("Di dalam fungsi: %d\n", level);
}

int main(void) {
    int level = 1;
    level_up();
    printf("Di luar fungsi: %d\n", level);
    return 0;
}
```

Output:

```
Di dalam fungsi: 2
Di luar fungsi: 1
```

## Variabel lokal

Variabel yang dibuat di dalam fungsi disebut **variabel lokal**. Variabel ini hanya ada
di dalam fungsi tersebut.

Pada contoh di atas, `level` di dalam `level_up` adalah kotak yang **berbeda** dari `level`
di dalam `main`, walaupun namanya sama. Mengubah yang satu tidak mengubah yang lain.

## Variabel hanya ada di dalam `{ }` tempat ia dibuat

Aturan ini juga berlaku untuk `{ }` milik `if` dan `for`:

```c
for (int i = 0; i < 3; i++) {
    int bonus = i * 10;
}
printf("%d\n", i);     // Error: i tidak dikenal di sini
printf("%d\n", bonus); // Error: bonus juga tidak dikenal
```

`i` dan `bonus` dibuat di dalam perulangan, jadi hilang setelah perulangannya selesai.
Jika kamu butuh nilainya setelah perulangan, buat variabelnya **sebelum** perulangan.

## Hati-hati: mengubah parameter tidak mengubah variabel aslinya

```c
void add_bonus(int xp) {
    xp = xp + 10;
}

int main(void) {
    int my_xp = 50;
    add_bonus(my_xp);
    printf("%d\n", my_xp); // 50, bukan 60
    return 0;
}
```

Parameter `xp` hanya menerima **salinan nilai** 50. Mengubah `xp` di dalam fungsi tidak
mengubah `my_xp`.

## Cara yang benar: kembalikan nilainya

```c
int add_bonus(int xp) {
    return xp + 10;
}

int main(void) {
    int my_xp = 50;
    my_xp = add_bonus(my_xp);
    printf("%d\n", my_xp); // 60
    return 0;
}
```

Ada cara lain untuk mengubah variabel dari dalam fungsi, yaitu memakai pointer. Kamu akan
mempelajarinya di level selanjutnya.

## Ingat

- Variabel hanya ada di dalam `{ }` tempat ia dibuat: fungsi, `if`, atau `for`.
- Variabel dengan nama sama di fungsi yang berbeda adalah dua kotak yang berbeda.
- Mengubah parameter tidak mengubah variabel yang dikirim.
- Untuk mengubah nilai, `return` nilai barunya lalu simpan: `my_xp = add_bonus(my_xp);`.
