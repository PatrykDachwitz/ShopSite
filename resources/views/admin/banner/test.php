<?php
namespace App;

use PDO;
use Exception;
class DataBase
{

    static private function Connect()
    {
        $Login=DB_login ?? "sales";
        $Password=DB_pass ?? "S5ales#pat62Qe";
        $Port=DB_port ?? "3306";
        $DB_name=DB_Basename ?? "salesscriptdb";
        $Host=DB_host ?? "192.168.15.233";
        $DB=new PDO('mysql:host='.$Host.';port='.$Port.';dbname='.$DB_name, $Login, $Password);
        return $DB;
    }

    static public function ADD_Amazon(string $Seler,int $Pages,int $Organic,int $Sponsored,int $Specialoffer,int $Amazonschoice,int $Bestseller,int $Round,string $User,string $Keyword, $Size = NULL, string $title, int $Organic_second=0, int $Sponsored_second=0, string $Country)
    {
        /*var_dump($Seler);
        var_dump($Pages);
        var_dump($Organic);
        var_dump($Sponsored);
        var_dump($Specialoffer);
        var_dump($Amazonschoice);
        var_dump($Bestseller);
        var_dump($Keyword);
        var_dump($Size);
        var_dump($title);
        var_dump($Organic_second);
        var_dump($Sponsored_second);
        var_dump($Country);

*/


        $Date=date("Y-m-d");
        $PDO = self::Connect();
        $tmp=$PDO->prepare("INSERT INTO amazon (Sellername, Page, Organic_first, Sponsored_first, Specialoffer, Amazonschoice, Bestseller,Round,User,Datecreated,Keyword,Size, Organic_second, Sponsored_second, Title, Country) VALUES (:Seler, :Pages, :Organic, :Sponsored, :Specialoffer, :Amazonschoice, :Bestseller,:Round,:User,:Date,:Keyword,:Size, :Organic_second, :Sponsored_second, :Title, :Country)");
        $tmp->BindParam(':Seler',$Seler);
        $tmp->BindParam(':Organic',$Organic);
        $tmp->BindParam(':Pages',$Pages);
        $tmp->BindParam(':Sponsored',$Sponsored);
        $tmp->BindParam(':Specialoffer',$Specialoffer);
        $tmp->BindParam(':Amazonschoice',$Amazonschoice);
        $tmp->BindParam(':Bestseller',$Bestseller);
        $tmp->BindParam(":Round",$Round);
        $tmp->BindParam(':Date',$Date);
        $tmp->BindParam(":User",$User);
        $tmp->BindParam(":Keyword", $Keyword);
        $tmp->BindParam(":Size",$Size);
        $tmp->BindParam(":Organic_second",$Organic_second);
        $tmp->BindParam(":Sponsored_second", $Sponsored_second);
        $tmp->BindParam(":Title",$title);
        $tmp->BindParam(':Country',$Country);
        $tmp->execute();//echo "<hr>";
    }

    static public function ADD_Allegro(string $Sellername,int $Organic_first,int $Sponsored_first,string $User,string $Keyword,int $Sellerspecial, int $Organic_second,int $Sponsored_second)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare("INSERT INTO allegro (Sellername, Organic_first, Sponsored_first, User, Keyword, Date, Sellerspecial, Organic_second, Sponsored_second) VALUES (:Sellername, :Organic_first, :Sponsored_first, :User, :Keyword, :Date, :Sellerspecial, :Organic_second, :Sponsored_second);");
        $tmp->BindParam(':Sellername',$Sellername);
        $tmp->BindParam(':Organic_first',$Organic_first);
        $tmp->BindParam(':Sponsored_first',$Sponsored_first);
        $tmp->BindParam(':User',$User);
        $tmp->BindParam(':Keyword',$Keyword);
        $tmp->BindParam(':Sellerspecial',$Sellerspecial);
        $tmp->BindParam(':Organic_second',$Organic_second);
        $tmp->BindParam(':Sponsored_second',$Sponsored_second);
        $tmp->BindParam(':Date',date("Y-m-d"));
        $tmp->execute();
    }

    static public function GetReportMail(string $Portal, int $Active=1)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('SELECT * from EmailRaport WHERE Active=:Active and Portal=:Portal');
        $tmp->BindParam(":Portal",$Portal);
        $tmp->BindParam(":Active",$Active);
        $tmp->execute();
        return $tmp->fetchAll();
    }

    static public function GetRaportEbayAnalytics(string $User)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('SELECT SellerName, SUM(Conversionvalue) as Conversionvalue, SUM(Quantitysold) as Quantitysold from EbayAnalytics WHERE User=:User GROUP BY SellerName ORDER BY  Conversionvalue DESC');
        $tmp->BindParam(":User",$User);
        $tmp->execute();
        return $tmp->fetchAll();
    }

    static public function GetRaportsSingleProduct(string $User)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('SELECT URL_item as Link, Title as Tittle, Quantitysold Value,Conversionvalue as Price,SellerName FROM ebayanalytics WHERE User=:User ORDER BY Conversionvalue DESC');
        $tmp->BindParam(":User",$User);
        $tmp->execute();
        return $tmp->fetchAll();
    }


    static public function GetRaportAmazonAnalytics(string $User)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('SELECT SellerName, SUM(Quantitysold) as Quantitysold from AmazonAnalytics WHERE User=:User GROUP BY SellerName ORDER BY Quantitysold DESC');
        $tmp->BindParam(":User",$User);
        $tmp->execute();
        return $tmp->fetchAll();
    }

    static public function RaporAmazon(string $User,string $Keyword, string $Country)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('SELECT Sellername, SUM(Organic_first) as Organic_first,SUM(Sponsored_first) as Sponsored_first,SUM(Specialoffer) as Specialoffer,SUM(Amazonschoice) as Amazonschoice,SUM(Bestseller) as Bestseller, GROUP_CONCAT(Size separator ",") as Size, SUM(Organic_second) as Organic_second, SUM(Sponsored_second) as Sponsored_second  FROM amazon WHERE User=:User AND Keyword=:Keyword AND Country=:Country  group by Sellername ORDER BY Sellername');
        $tmp->BindParam(":User",$User);
        $tmp->BindParam(":Keyword",$Keyword);
        $tmp->BindParam(":Country", $Country);
        $tmp->execute();
        return $tmp->fetchAll();
    }

    static public function AllegroResult(string $Keyword,string $User)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('SELECT Sellername, SUM(Organic_first) as Organic_first,  SUM(Sponsored_first) as Sponsored_first, SUM(Sellerspecial) as Sellerspecial, SUM(Organic_second) as Organic_second, SUM(Sponsored_second) as Sponsored_second  FROM allegro WHERE Keyword=:Keyword AND User=:User GROUP BY Sellername ORDER BY Sellername');
        $tmp->BindParam(":User",$User);
        $tmp->BindParam(":Keyword",$Keyword);
        $tmp->execute();
        return $tmp->fetchAll();
    }


    static public function RaporEbay(string $User,string $Keyword, string $Country)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('SELECT ebay.Sellername, SUM(ebay.Specialoffer) as Specialoffer, SUM(ebay.Sponsored_first) as sponsoredF, SUM(ebay.Organic_first) as organicF, SUM(ebay.Sponsored_second) as sponsoredS,
        SUM(ebay.Organic_second) as organicS from ebay  WHERE ebay.User=:User AND ebay.Keyword=:Keyword AND ebay.Country=:Country GROUP by ebay.Sellername ORDER by ebay.Sellername');
        // var_dump($tmp);
        //   echo "<hr>$User<hr>$Keyword";
        $tmp->BindParam(":User",$User);
        $tmp->BindParam(":Keyword",$Keyword);
        $tmp->BindParam(":Country",$Country);
        $tmp->execute();
        return $tmp->fetchAll();
    }


    static public function nowTopRated(string $Country)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('SELECT Sellername from ebay_toprated WHERE Datecreated=:Date and Top_rated > 0 and Country=:Country GROUP by Sellername');

        $tmp->BindParam(":Country",$Country);
        $tmp->BindParam(":Date",date("Y-m-d"));
        $tmp->execute();
        return $tmp->fetchAll();
    }

    static public function setanalyticsEbay(string $Product_id,string $CountryISO,string $URL_item,string  $Title, $Quantitysold,float $Conversionvalue, string $SellerName, string $User)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('INSERT INTO EbayAnalytics (Product_id, CountryISO, URL_item, Title, Quantitysold, Conversionvalue, SellerName, User) VALUES (:Product_id, :CountryISO, :URL_item, :Title, :Quantitysold, :Conversionvalue, :SellerName, :User)');

        $tmp->BindParam(":Product_id",$Product_id);
        $tmp->BindParam(":CountryISO",$CountryISO);
        $tmp->BindParam(":URL_item",$URL_item);
        $tmp->BindParam(":Title",$Title);
        $tmp->BindParam(":Quantitysold",$Quantitysold);
        $tmp->BindParam(":Conversionvalue",$Conversionvalue);
        $tmp->BindParam(":SellerName",$SellerName);
        $tmp->BindParam(":User",$User);
        $tmp->execute();
        return $tmp->fetchAll();
    }

    static public function AddNewSuperSale(string $SellerName,string $SuperSale,string $DataCurrenty)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('INSERT INTO allegrosupersale(DataCurrenty, SuperSale, SellerName) VALUES (:DataCurrenty, :SuperSale, :SellerName)');

        $tmp->BindParam(":SellerName",$SellerName);
        $tmp->BindParam(":SuperSale",$SuperSale);
        $tmp->BindParam(":DataCurrenty",$DataCurrenty);
        $tmp->execute();
        return true;
    }
    static public function GetSuperSale(string $DataCurrenty, array $ListSqlSuperSale)
    {
        //var_dump($ListSqlSuperSale);

        $TmpListSeller=implode('","',$ListSqlSuperSale);
        $TmpListSeller='("'.$TmpListSeller.'")';//var_dump($TmpListSeller);
        $PDO = self::Connect();
        $tmp=$PDO->prepare("select SellerName,sum(SuperSale) as SuperSale from allegrosupersale where DataCurrenty=:DataCurrenty AND SellerName in $TmpListSeller group by SellerName");

        $tmp->BindParam(":DataCurrenty",$DataCurrenty);
        $tmp->execute();
        return $tmp->fetchAll();
    }
    static public function setanalyticsAmazon(string $CountryISO,string  $Title,string $Quantitysold, string $SellerName, string $User)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('INSERT INTO AmazonAnalytics (CountryISO, Title, Quantitysold, SellerName, User) VALUES (:CountryISO, :Title, :Quantitysold, :SellerName, :User)');

        $tmp->BindParam(":CountryISO",$CountryISO);

        $tmp->BindParam(":Title",$Title);
        $tmp->BindParam(":Quantitysold",$Quantitysold);
        $tmp->BindParam(":SellerName",$SellerName);
        $tmp->BindParam(":User",$User);
        $tmp->execute();
        return true;
    }

    static public function YesterTopRated(string $Country)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('SELECT Sellername from ebay_toprated WHERE Datecreated=:Date and Top_rated > 0 and Country=:Country GROUP by Sellername');

        $tmp->BindParam(":Country",$Country);
        $tmp->BindParam(":Date",date("Y-m-d",strtotime("-1 day")));
        $tmp->execute();
        return $tmp->fetchAll();
    }

    static public function RoundNumber(string $User,string $Keyword,string $Country)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('SELECT SUM(Round) as RoundN FROM amazon WHERE User = :User AND Keyword = :Keyword AND Country = :Country');
        $tmp->BindParam(":User",$User);
        $tmp->BindParam(":Keyword",$Keyword);
        $tmp->BindParam(":Country", $Country);
        $tmp->execute();
        return $tmp->fetch();
    }

    static public function clearanalyticsEbay(string $User)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('DELETE from EbayAnalytics WHERE User=:User');
        $tmp->BindParam(":User",$User);
        $tmp->execute();
        return true;
    }

    static public function clearanalyticsAmazon(string $User)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('DELETE from AmazonAnalytics WHERE User=:User');
        $tmp->BindParam(":User",$User);
        $tmp->execute();
        return true;
    }


    static public function SellerTop(string $User,string $Keyword)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('SELECT Sellername from ebay WHERE User=:User and Keyword=:Keyword GROUP by Sellername');
        $tmp->BindParam(":User",$User);
        $tmp->BindParam(":Keyword",$Keyword);
        $tmp->execute();
        return $tmp->fetchALL();
    }


    static public function DeleteResults(string $User, string $Country)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('delete from amazon WHERE User = :User AND Country = :Country');
        $tmp->BindParam(":User",$User);
        $tmp->BindParam(":Country", $Country);
        $tmp->execute();
        return true;
    }


    static public function ADD_Ebay(string $Sellername, string $User, int $Page, int $Organic_first, int $Sponsored_first, int $Specialoffer, string $Keyword, int $Organic_second, int $Sponsored_second, string $Country)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare("INSERT INTO ebay (User, Sellername, Page, Organic_first, Sponsored_first, Specialoffer, Datecreated, Keyword, Organic_second, Sponsored_second, Country) VALUES (:User, :Sellername, :Page, :Organic_first, :Sponsored_first, :Specialoffer, :Datecreated, :Keyword, :Organic_second, :Sponsored_second, :Country)");
        $tmp->BindParam(":User",$User);
        $tmp->BindParam(':Sellername',$Sellername);
        $tmp->BindParam(':Page',$Page);
        $tmp->BindParam(':Organic_first',$Organic_first);
        $tmp->BindParam(':Sponsored_first',$Sponsored_first);
        $tmp->BindParam(':Specialoffer',$Specialoffer);
        $tmp->BindParam(':Datecreated',date("Y-m-d"));
        $tmp->BindParam(':Keyword',$Keyword);
        $tmp->BindParam(':Organic_second',$Organic_second);
        $tmp->BindParam(":Sponsored_second",$Sponsored_second);
        $tmp->BindParam(":Country",$Country);
        $tmp->execute();
    }

    static public function ADD_TopRatedEbay(string $Sellername, int $TopRated)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('INSERT INTO ebay_toprated (Sellername, Datecreated, Top_rated) VALUES (:Sellername, :Datecreated, :Top_rated)');
        $tmp->BindParam(':Datecreated', date("Y-m-d"));
        $tmp->BindParam(':Sellername', $Sellername);
        $tmp->BindParam(':Top_rated', $TopRated);
        $tmp->execute();
    }

    static public function ADD_Resultautomaticraport(string $Sellername, int $Organic, int $Sponsored,string $Country, string $Keyword,string  $Data_Crrrenty="")
    {
        if(empty($Data_Crrrenty))   $Data_Crrrenty=date("Y-m-d");
        try{
            $PDO = self::Connect();
            $tmp=$PDO->prepare('INSERT INTO AmazonRaport (Sellername, Datecreated, Organic,Sponsored, Country,Keyword) VALUES (:Sellername, :Datecreated, :Organic,:Sponsored, :Country,:Keyword)');
            $tmp->BindParam(':Datecreated', $Data_Crrrenty);
            $tmp->BindParam(':Sellername', $Sellername);
            $tmp->BindParam(':Organic', $Organic);
            $tmp->BindParam(':Sponsored', $Sponsored );
            $tmp->BindParam(':Country', $Country);
            $tmp->BindParam(':Keyword', $Keyword);
            $tmp->execute();
        }
        catch(Exception $e)
        {
            echo $e;
        }
    }
    static public function Get_Resultautmoatic(string $Keyword, string $Country, string $Date)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('SELECT Sellername, Organic, Sponsored FROM AmazonRaport WHERE Keyword=:Keyword AND Country=:Country and Datecreated=:Datecreated ORDER BY Sellername ASC');
        $tmp->BindParam(':Datecreated', $Date);//,strtotime("-$Day day")
        $tmp->BindParam(':Keyword', $Keyword);
        $tmp->BindParam(':Country', $Country);
        $tmp->execute();
        return $tmp->fetchALL();
    }

    static public function Get_Keywords_Raport(string $Country, string $Portal)
    {
        $PDO = self::Connect();
        $SQL='SELECT Value from RaportKeywords WHERE Active=1 AND Country= :Country AND Portal= :Portal';
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Country', $Country);
        $tmp->BindParam(':Portal', $Portal);
        $tmp->execute();
        return  $tmp->fetchALL(PDO::FETCH_ASSOC);

    }

    static public function Get_Keywords_Raport_ALL(string $Country, string $Portal)
    {
        $PDO = self::Connect();
        $SQL='SELECT ID, Value as Name, Active from RaportKeywords WHERE Portal=:Portal AND Country=:Country ORDER BY Active';
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Country', $Country);
        $tmp->BindParam(':Portal', $Portal);
        $tmp->execute();
        return  $tmp->fetchALL(PDO::FETCH_ASSOC);

    }

    static public function GET_TRANSLATION_ROUND(string $Country, string $Portal)
    {
        $PDO = self::Connect();
        $SQL='SELECT * from Roundtranslation WHERE Portal=:Portal AND Country_ISO=:Country ORDER BY Active';
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Country', $Country);
        $tmp->BindParam(':Portal', $Portal);
        $tmp->execute();
        return  $tmp->fetchALL(PDO::FETCH_ASSOC);

    }
    static public function GET_TRANSLATION_ROUND_RAPORT(string $Country)
    {
        $PDO = self::Connect();
        $SQL='SELECT * from Roundtranslation WHERE Portal="Amazon" AND Country_ISO=:Country AND Active=1';
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Country', $Country);
        $tmp->execute();
        return  $tmp->fetchALL(PDO::FETCH_ASSOC);

    }
    static public function ActiveCountru(string $Portal)
    {
        $SQL='SELECT CountryISO, Country from CountryRaport where Active=1 AND Portal=:Portal';
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Portal', $Portal);
        $tmp->execute();
        return  $tmp->fetchALL(PDO::FETCH_ASSOC);

    }



    static public function UpdateKeywords(string $ID,string $Value, string $Portal, string $Active)
    {
        $SQL='UPDATE RaportKeywords SET Value = :Value, Active = :Active WHERE ID = :ID AND Portal=:Portal;';
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Value', $Value);
        $tmp->BindParam(':Active', $Active);
        $tmp->BindParam(':ID', $ID);
        $tmp->BindParam(':Portal', $Portal);
        $tmp->execute();
    }


    static public function UpdateMailRaport(string $ID, string $Active)
    {
        $SQL='UPDATE emailraport SET Active = :Active WHERE ID = :ID;';
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Active', $Active);
        $tmp->BindParam(':ID', $ID);
        $tmp->execute();
    }


    static public function UpdateCountry(string $ISO,int $Active, string $Portal)
    {

        $SQL='UPDATE CountryRaport SET Active = :Active WHERE CountryISO = :ISO AND Portal = :Portal;';
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Active', $Active);
        $tmp->BindParam(':Portal', $Portal);
        $tmp->BindParam(':ISO', $ISO);
        $tmp->execute();
    }

    static public function Updateforeclosure(string $ID, string $keyword, int $Active, string $Portal)
    {
        /*var_dump($ID);
        $Active=1;
        var_dump($Active);

        var_dump($Portal);*/
        $SQL='UPDATE foreclosure SET Active = :Active, Link = :Link  WHERE ID = :ID AND Place = :Portal;';
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Link', $keyword);
        $tmp->BindParam(':Active', $Active);
        $tmp->BindParam(':Portal', $Portal);
        $tmp->BindParam(':ID', $ID);
        $tmp->execute();
    }

    static public function SetNewKeywords(string $Value, string $Portal, string $Active, string $Country)
    {
        $SQL='INSERT INTO RaportKeywords (Country, Value, Active, Portal) VALUES (:Country, :Value, :Active, :Portal);';
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Value', $Value);
        $tmp->BindParam(':Country', $Country);
        $tmp->BindParam(':Active', $Active);
        $tmp->BindParam(':Portal', $Portal);
        $tmp->execute();
    }

    static public function SetRoundsTranslation(string $Value, string $Country, string $Active, string $Portal)
    {
        $SQL='INSERT INTO Roundtranslation (Name, Portal, Active, Country_ISO) VALUES (:Name, :Portal, :Active, :Country_ISO);';
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Name', $Value);
        $tmp->BindParam(':Country_ISO', $Country);
        $tmp->BindParam(':Active', $Active);
        $tmp->BindParam(':Portal', $Portal);
        $tmp->execute();
    }

    static public function CountryList(string $Portal)
    {
        $SQL='SELECT CountryISO, Country, Active from CountryRaport where Portal=:Portal';
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Portal', $Portal);
        $tmp->execute();
        return  $tmp->fetchALL(PDO::FETCH_ASSOC);

    }

    static public function GetSeller(string $Country)
    {
        $SQL='SELECT Sellername from ebay WHERE Country = :Country';
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Country', $Country);
        $tmp->execute();
        return  $tmp->fetchALL(PDO::FETCH_ASSOC);
    }

    static public function GetSellerAutomatic(string $Country)
    {
        $SQL='SELECT Name from ebayseller where Country=:Country GROUP BY Name';
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Country', $Country);
        $tmp->execute();
        return  $tmp->fetchALL(PDO::FETCH_ASSOC);
    }

    static public function FullListSeller(string $Country,string $Seller=NULL)
    {
        if(empty($Seller)) $Seller='Ebay';
        $SQL="SELECT Sellername from ebay where Sellername NOT in ($Seller) AND Country=:Country GROUP BY Sellername";
        //  var_dump($SQL);
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Country', $Country);
        //  $tmp->BindParam(':Seller', $Seller);
        $tmp->execute();

        return  $tmp->fetchALL();
    }
    static public function UpdateSeller(string $Country,$Sellers)
    {

        $SQL="INSERT INTO ebayseller (Name, Country) VALUES (:Seller, :Country);";
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Country', $Country);
        foreach($Sellers as $Seller)
        {
            $tmp->BindParam(':Seller', $Seller['Sellername']);
            $tmp->execute();
        }
    }
    static public function EbayCountry()
    {
        $SQL='SELECT CountryISO FROM CountryRaport';
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->execute();
        return  $tmp->fetchALL(PDO::FETCH_ASSOC);
    }

    static public function AddTopSeler(string $Seller,string $Country,int $Top_Rated)
    {
        $SQL="INSERT INTO ebay_toprated (Sellername, Datecreated, Top_rated, Country) VALUES (:Seller, :Datecreated, :Top_Rated, :Country);";
        // var_dump($SQL);
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Country', $Country);
        $tmp->BindParam(':Seller', $Seller);
        $tmp->BindParam(':Top_Rated', $Top_Rated);
        $tmp->BindParam(':Datecreated', date("Y-m-d"));
        $tmp->execute();
    }

    static public function ClearSelerToDay(string $Country)
    {
        $SQL="DELETE FROM ebay_toprated WHERE Datecreated = :Datecreated AND  Country=:Country";
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Datecreated', date("Y-m-d"));
        $tmp->BindParam(':Country', $Country);
        $tmp->execute();
    }

    static public function ViewTopRated(string $Country, string $Date)
    {
        $SQL="SELECT Sellername, Top_rated from ebay_toprated WHERE Datecreated=:Datecreated AND Country=:Country";
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Datecreated', $Date);
        $tmp->BindParam(":Country",$Country);
        $tmp->execute();
        return $tmp->fetchALL(PDO::FETCH_ASSOC);
    }

    static public function ClearResult(string $Country, string $User)
    {
        $SQL="DELETE FROM ebay WHERE User = :User AND  Country=:Country";
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':User', $User);
        $tmp->BindParam(':Country', $Country);
        $tmp->execute();
    }

    static public function ClearResultALL(string $Country)
    {
        $SQL="DELETE FROM ebay WHERE User !='Raport' AND  Country=:Country";
        $PDO = self::Connect();
        $tmp=$PDO->prepare($SQL);
        $tmp->BindParam(':Country', $Country);
        $tmp->execute();
    }

    static public function Get_ResultautmoaticEbay(string $Keyword, string $Country, string $Date)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('SELECT Sellername, Organic_second, Sponsored_second, Sponsored_first, Organic_first from ebayRaport WHERE Keyword=:Keyword AND Country=:Country and Datecreated=:Datecreated ORDER BY Sellername');
        $tmp->BindParam(':Datecreated', $Date);//,strtotime("-$Day day")
        $tmp->BindParam(':Keyword', $Keyword);
        $tmp->BindParam(':Country', $Country);
        $tmp->execute();
        return $tmp->fetchALL();
    }

    static public function Getforeclosure(string $Place, int $Active=1)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('SELECT * from foreclosure WHERE Place=:Place AND Active=:Active ORDER BY Active ASC');
        //$tmp->BindParam(':Datecreated', date("Y-m-d",strtotime("-$Day day")));//,strtotime("-$Day day")
        $tmp->BindParam(':Active', $Active);
        $tmp->BindParam(':Place', $Place);
        $tmp->execute();
        return $tmp->fetchALL();
    }


    static public function ClearAllegro(string $Keyword, string $User)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('DELETE FROM allegro WHERE Keyword=:Keyword AND User=:User');
        $tmp->BindParam(':User', $User);
        $tmp->BindParam(':Keyword', $Keyword);
        $tmp->execute();
    }

    static public function Set_ResultautmoaticEbay(string $Sellername,string $Country,int $Organic_second,int $Sponsored_second,int $Sponsored_first,int $Organic_first,string  $Keyword)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('INSERT INTO ebayRaport (Datecreated, Sellername, Country, Organic_second, Sponsored_second, Sponsored_first, Organic_first, Keyword) VALUES (:Datecreated, :Sellername, :Country, :Organic_second, :Sponsored_second, :Sponsored_first, :Organic_first, :Keyword);');
        $tmp->BindParam(':Datecreated', date("Y-m-d"));
        $tmp->BindParam(':Keyword', $Keyword);
        $tmp->BindParam(':Sellername', $Sellername);
        $tmp->BindParam(':Country', $Country);
        $tmp->BindParam(':Organic_second', $Organic_second);
        $tmp->BindParam(':Sponsored_second', $Sponsored_second);
        $tmp->BindParam(':Sponsored_first', $Sponsored_first);
        $tmp->BindParam(':Organic_first', $Organic_first);
        $tmp->execute();
    }

    static public function Setforeclosure(string $Link,string $Place,int  $Active=1)
    {
        $PDO = self::Connect();
        $tmp=$PDO->prepare('INSERT INTO foreclosure (Active, Place, Link) VALUES (:Active, :Place, :Link);');
        $tmp->BindParam(':Link', $Link);
        $tmp->BindParam(':Place', $Place);
        $tmp->BindParam(':Active', $Active);
        $tmp->execute();
    }
}




?>