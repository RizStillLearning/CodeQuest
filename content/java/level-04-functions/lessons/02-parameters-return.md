---
id: java-l4-parameters-return
title: Parameter dan return
order: 2
xp: 20
---

## Coba ini

```java
static int addXp(int xp, int bonus) {
    return xp + bonus;
}

public static void main(String[] args) {
    int total = addXp(50, 10);
    System.out.println(total);
}
```

Output:

```
60
```

## Parameter: mengirim data ke method

**Parameter** adalah variabel yang menerima nilai saat method dipanggil. Nilai yang
dikirim disebut **argumen**. Di Java, setiap parameter ditulis dengan tipenya: `int xp, int bonus`.

| Pemanggilan | `xp` | `bonus` |
|---|---|---|
| `addXp(50, 10)` | 50 | 10 |
| `addXp(10, 50)` | 10 | 50 |

Argumen dimasukkan ke parameter **sesuai urutannya**. Jumlah dan tipenya juga harus cocok:
`addXp(50)` atau `addXp("50", 10)` menyebabkan error saat compile.

## `return`: mengembalikan hasil

Kata sebelum nama method adalah **tipe hasilnya** (return type):

| Return type | Artinya |
|---|---|
| `void` | tidak mengembalikan nilai |
| `int` | mengembalikan bilangan bulat |
| `double` | mengembalikan bilangan desimal |
| `String` | mengembalikan teks |
| `boolean` | mengembalikan `true` atau `false` |

`return` mengirim nilai kembali ke tempat method dipanggil, dan **langsung menghentikan method**:

```java
static String getGrade(int score) {
    if (score >= 80) {
        return "A";
    } else if (score >= 60) {
        return "B";
    }
    return "C";
}

public static void main(String[] args) {
    System.out.println(getGrade(85));
    System.out.println(getGrade(70));
    System.out.println(getGrade(40));
}
```

Output:

```
A
B
C
```

## Hati-hati: setiap jalur harus punya `return`

Jika return type bukan `void`, setiap kemungkinan jalur kode harus berakhir dengan `return`.
Jika tidak, Java menolak meng-compile dengan error `missing return statement`.

Java tidak memeriksa apakah kondisi-kondisimu sudah mencakup semua angka. Jadi akhiri
dengan `else` atau dengan `return` di bagian akhir, seperti `return "C";` pada contoh di atas.

## Hati-hati: `println` bukan `return`

```java
static void doubleIt(int number) {
    System.out.println(number * 2);
}

public static void main(String[] args) {
    int result = doubleIt(5); // Error: method void tidak menghasilkan nilai
}
```

`println` hanya **menampilkan** nilai di layar. Jika hasilnya akan dipakai, ganti `void`
menjadi `int` dan pakai `return number * 2;`.

## Ingat

- Setiap parameter ditulis dengan tipenya, dan argumen dimasukkan sesuai urutan.
- Return type menentukan jenis nilai yang dikembalikan. `void` berarti tidak ada.
- `return` mengembalikan hasil dan langsung menghentikan method.
- Jika bukan `void`, setiap jalur kode harus berakhir dengan `return`.
