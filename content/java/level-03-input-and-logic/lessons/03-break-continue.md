---
id: java-l3-break-continue
title: break dan continue
order: 3
xp: 20
---

## Coba ini

```java
public class Main {
    public static void main(String[] args) {
        for (int i = 1; i <= 5; i++) {
            if (i == 4) {
                break;
            }
            System.out.println(i);
        }
        System.out.println("Selesai");
    }
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
pernah ditampilkan, tetapi `"Selesai"` tetap ditampilkan.

## `continue`: lewati putaran ini

`continue` melompati sisa kode di putaran ini, lalu lanjut ke putaran berikutnya:

```java
for (int i = 1; i <= 5; i++) {
    if (i == 3) {
        continue;
    }
    System.out.println(i);
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

## Ulangi sampai benar: `while (true)`

```java
Scanner input = new Scanner(System.in);
while (true) {
    System.out.print("Berapa 2 + 2? ");
    int answer = input.nextInt();
    if (answer == 4) {
        System.out.println("Benar!");
        break;
    }
    System.out.println("Salah, coba lagi.");
}
```

Output, jika kamu mengetik `5`, lalu `4`:

```
Berapa 2 + 2? 5
Salah, coba lagi.
Berapa 2 + 2? 4
Benar!
```

Kondisi `while (true)` selalu `true`, jadi perulangan ini hanya bisa berhenti dengan `break`.
Pola ini cocok untuk mengulang pertanyaan sampai jawabannya benar.

## Ingat

- `break;` menghentikan perulangan.
- `continue;` melompati sisa putaran ini, lalu lanjut ke putaran berikutnya.
- `while (true)` berulang terus sampai bertemu `break;`.
