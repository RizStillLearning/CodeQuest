---
id: c-l3-break-continue
title: break dan continue
order: 3
xp: 20
---

## Coba ini

```c
#include <stdio.h>

int main(void) {
    for (int i = 1; i <= 5; i++) {
        if (i == 4) {
            break;
        }
        printf("%d\n", i);
    }
    printf("Selesai\n");
    return 0;
}
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
pernah ditampilkan, tetapi `Selesai` tetap ditampilkan.

## `continue`: lewati putaran ini

`continue` melompati sisa kode di putaran ini, lalu lanjut ke putaran berikutnya:

```c
for (int i = 1; i <= 5; i++) {
    if (i == 3) {
        continue;
    }
    printf("%d\n", i);
}
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

## Ulangi sampai benar: `while (1)`

```c
int answer = 0;
while (1) {
    printf("Berapa 2 + 2? ");
    scanf("%d", &answer);
    if (answer == 4) {
        printf("Benar!\n");
        break;
    }
    printf("Salah, coba lagi.\n");
}
```

Output, jika kamu mengetik `5`, lalu `4`:

```
Berapa 2 + 2? 5
Salah, coba lagi.
Berapa 2 + 2? 4
Benar!
```

Di C, `1` berarti benar, jadi `while (1)` berulang terus dan hanya bisa berhenti dengan `break`.
Pola ini cocok untuk mengulang pertanyaan sampai jawabannya benar.

Catatan: jika pengguna mengetik huruf, `scanf("%d", ...)` gagal membaca, dan perulangan ini
bisa berulang tanpa henti. Cara memeriksa input seperti ini akan kamu pelajari di level selanjutnya.

## Ingat

- `break;` menghentikan perulangan.
- `continue;` melompati sisa putaran ini, lalu lanjut ke putaran berikutnya.
- `while (1)` berulang terus sampai bertemu `break;`.
