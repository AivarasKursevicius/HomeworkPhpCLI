<?php
/**
 * Created by PhpStorm.
 * User: Aivaras
 * Date: 21/09/2018
 * Time: 00:48
 */

const DB_FILE_NAME = "database.txt";

//funkcija kuri atidaro duomenu bazes faila ir eilutes konvertuoja i stringa ir iraso i duomenu
//bazes faila
function writeToFile($linesArray) {
    $myfile = fopen(DB_FILE_NAME, "w") or die("Unable to open file!");
    fwrite($myfile, implode("\r\n", $linesArray));
    fclose($myfile);
}

//printArray funkcija paims duomenis is duomenu bazes eilutem ir irasines i konsole.
//tuo paciu metu jis numeruos kieviena eilute nuo 0.
function printArray($array) {
    for ($i = 0; $i < count($array); $i++) {
        echo "$i. $array[$i] \n";
    }
}

//cia yra loop'as kuris paleidzia programa per nauja
do {

//cia yra pati pradzia programos kuri duoda pasirinkima useriui ka jis nori daryti su programa
    echo "0. Exit\n";
    echo "1. Ivesti nauja vartotoja\n";
    echo "2. Redaguoti vartotoja\n";
    echo "3. Istrynti vartotoja\n";
    echo "Iveskite skaiciu ir spauskite enter: ";
    $option = readline();

    // Skaitymas is failo
    $myfile = fopen(DB_FILE_NAME, "r+") or die("Unable to open file!");
    $fileContent = fread($myfile, filesize(DB_FILE_NAME)); // cia yra failo tusinys viename Stringe tipes String
    $fileContentLineByLine = explode("\r\n", $fileContent); // cia yra failas isskaidytas kas eilute tipas Array
    fclose($myfile);


    //switch yra naudojamas vietoj 'if' nes yera patogiau kai yra 3 arba daugiau pasirinkimu.
    //case 0 isjungia programa kai user iveda numeri 0
    switch ($option) {
        case "0":
            exit;
            break;
        //case 1 paeiliuj leidzia ivesti kliento informacija i database.
        //kai userio informacija buna su trim'inta(istrina tarpus prieki ir gale) ir palieka kableli
        // prieki.
        //Visi 6 elementai susijungia naudojant '.' ir tada naudojant 'array_push' ta eilute
        //istumia i apacia listo duomenu bazeje.
        case "1":
            echo "Vardas: ";
            $firstname = readline();
            echo "Pavarde: ";
            $lastname = readline();
            echo "Email: ";
            $email = readline();
            echo "Mobilus Tel: ";
            $phonenumber1 = readline();
            echo "Namu Tel: ";
            $phonenumber2 = readline();
            echo "Komentaras: ";
            $comment = readline();
            $user = trim($firstname)
                . "," . trim($lastname)
                . "," . trim($email)
                . "," . trim($phonenumber1)
                . "," . trim($phonenumber2)
                . "," . trim($comment);

            array_push($fileContentLineByLine, $user);

            // Rasymas i duomenu baze
            writeToFile($fileContentLineByLine);
            break;
            //printArray funkcija paims duomenis is duomenu bazes eilutem ir irasines i konsole.
        //tuo paciu metu jis numeruos kieviena eilute nuo 0.
        case "2":

            echo "Vartotoju sarasas: \n";
            printArray($fileContentLineByLine);
            //sita dalis explode(atskirs eilute pasirinkta i atskirus stringus)
            echo "Iveskite vartotojo numeri: ";
            $userNumber = readline();
            $user = $fileContentLineByLine[$userNumber];
            $firstname = explode(",", $user)[0];
            $lastname = explode(",", $user)[1];
            $email = explode(",", $user)[2];
            $phonenumber1 = explode(",", $user)[3];
            $phonenumber2 = explode(",", $user)[4];
            $comment = explode(",", $user)[5];

            // Naujau vardu ivedimas
            echo "Vardas [$firstname] ";
            $firstnameNew = trim(readline());
            if (!empty($firstnameNew))
                $firstname = $firstnameNew;
            echo "Pavarde [$lastname] ";
            $lastnameNew = trim(readline());
            if (!empty($lastnameNew))
                $lastname = $lastnameNew;
            echo "Email: [$email]";
            $emailNew = trim(readline());
            if (!empty($emailNew))
                $email = $emailNew;
            echo "Mobilus Tel: [$phonenumber1]";
            $phonenumber1New = trim(readline());
            if (!empty($phonenumber1New))
                $phonenumber1 = $phonenumber1New;
            echo "Namu Tel: [$phonenumber2]";
            $phonenumber2New = trim(readline());
            if (!empty($phonenumber2New))
                $phonenumber2 = $phonenumber2New;
            echo "Komentaras: [$comment]";
            $commentNew = trim(readline());
            if (!empty($commentNew))
                $comment = $commentNew;
            //Sujungimas visu 6 stringu i viena eilute
            $user = trim($firstname)
                . "," . trim($lastname)
                . "," . trim($email)
                . "," . trim($phonenumber1)
                . "," . trim($phonenumber2)
                . "," . trim($comment);
            $fileContentLineByLine[$userNumber] = $user;


            // Rasymas i faila
            writeToFile($fileContentLineByLine);
            break;
        case "3":
            //printArray funkcija paims duomenis is duomenu bazes eilutem ir irasines i konsole.
            //tuo paciu metu jis numeruos kieviena eilute nuo 0.
            echo "Vartotoju sarasas: \n";
            printArray($fileContentLineByLine);
            //is array istrina tam tikra elementa pagal paduota skaiciu
            echo "Iveskite vartotojo numeri kuri norite istrynti: ";
            $userNumber = readline();
            array_splice($fileContentLineByLine, $userNumber);

            //myfile atidaro database, tada i myfile(database) praso ir sujungia visas eilutes
            //ir prideda eilutes gale \n(enter). Ir tada uzdaro myfile(database).
            writeToFile($fileContentLineByLine);
            break;
    }

} while ($option != "0");