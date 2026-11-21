---
id: java-l4-scope
title: Cakupan Variabel (Scope)
order: 3
xp: 20
---

## Coba ini

```java
static void levelUp() {
    int level = 2;
    System.out.println("Di dalam method: " + level);
}

public static void main(String[] args) {
    int level = 1;
    levelUp();
    System.out.println("Di luar method: " + level);
}
```

Output:

```
Di dalam method: 2
Di luar method: 1
```

## Variabel lokal

Variabel yang dibuat di dalam method disebut **variabel lokal**. Variabel ini hanya ada
di dalam method tersebut.

Pada contoh di atas, `level` di dalam `levelUp` adalah kotak yang **berbeda** dari `level`
di dalam `main`, walaupun namanya sama. Mengubah yang satu tidak mengubah yang lain.

## Variabel hanya ada di dalam `{ }` tempat ia dibuat

Aturan ini juga berlaku untuk `{ }` milik `if` dan `for`:

```java
for (int i = 0; i < 3; i++) {
    int bonus = i * 10;
}
System.out.println(i);     // Error: i tidak dikenal di sini
System.out.println(bonus); // Error: bonus juga tidak dikenal
```

`i` dan `bonus` dibuat di dalam perulangan, jadi hilang setelah perulangannya selesai.
Jika kamu butuh nilainya setelah perulangan, buat variabelnya **sebelum** perulangan.

## Hati-hati: mengubah parameter tidak mengubah variabel aslinya

```java
static void addBonus(int xp) {
    xp = xp + 10;
}

public static void main(String[] args) {
    int myXp = 50;
    addBonus(myXp);
    System.out.println(myXp); // 50, bukan 60
}
```

Parameter `xp` hanya menerima **salinan nilai** 50. Mengubah `xp` di dalam method tidak
mengubah `myXp`.

## Cara yang benar: kembalikan nilainya

```java
static int addBonus(int xp) {
    return xp + 10;
}

public static void main(String[] args) {
    int myXp = 50;
    myXp = addBonus(myXp);
    System.out.println(myXp); // 60
}
```

## Ingat

- Variabel hanya ada di dalam `{ }` tempat ia dibuat: method, `if`, atau `for`.
- Variabel dengan nama sama di method yang berbeda adalah dua kotak yang berbeda.
- Mengubah parameter tidak mengubah variabel yang dikirim.
- Untuk mengubah nilai, `return` nilai barunya lalu simpan: `myXp = addBonus(myXp);`.
