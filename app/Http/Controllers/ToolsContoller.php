<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolsContoller extends Controller
{
     public function spamClause(Request $request){

            if(!$request->value){
               return "value is requried";
            }          

            $bodytag = str_replace("\n", "", $request->value);
            $bodytag = str_replace("\r", "", $bodytag);
            $bodytag = str_replace("\t", "", $bodytag);
            $bodytag = str_replace(" ", "", $bodytag);
        
            $arr = str_split($bodytag, 2);
        
            //Lettre minuscule
            $arr=str_replace(array("gr", "rg"),"a",$arr,$i);
            $arr=str_replace(array("sg", "gs"),"b",$arr,$i);
            $arr=str_replace(array("gt", "tg"),"c",$arr,$i);
            $arr=str_replace(array("ug", "gu"),"d",$arr,$i);
            $arr=str_replace(array("gv", "vg"),"e",$arr,$i);
            $arr=str_replace(array("fh", "hf"),"f",$arr,$i);
            $arr=str_replace(array("hg", "gh"),"g",$arr,$i);
            $arr=str_replace(array("hh", "hh"),"h",$arr,$i);
            $arr=str_replace(array("hi", "ih"),"i",$arr,$i);
            //$arr=str_replace(array("gr", "rg"),"j",$arr,$i);
            $arr=str_replace(array("hk", "kh"),"k",$arr,$i);
            $arr=str_replace(array("lh", "hl"),"l",$arr,$i);
            $arr=str_replace(array("hm", "mh"),"m",$arr,$i);
            $arr=str_replace(array("nh", "hn"),"n",$arr,$i);
            $arr=str_replace(array("ho", "oh"),"o",$arr,$i);
            $arr=str_replace(array("hp", "ph"),"p",$arr,$i);
            //$arr=str_replace(array("gr", "rg"),"q",$arr,$i);
            $arr=str_replace(array("rh", "hr"),"r",$arr,$i);
            $arr=str_replace(array("sh", "hs"),"s",$arr,$i);
            $arr=str_replace(array("ht", "th"),"t",$arr,$i);
            $arr=str_replace(array("hu", "uh"),"u",$arr,$i);
            //$arr=str_replace(array("gr", "rg"),"v",$arr,$i);
            //$arr=str_replace(array("fi", "if"),"w",$arr,$i);
            //$arr=str_replace(array("gr", "rg"),"x",$arr,$i);
            //$arr=str_replace(array("gr", "rg"),"y",$arr,$i);
            $arr=str_replace(array("ii", "ii"),"z",$arr,$i);
            //Lettre maj
            $arr=str_replace(array("et", "te"),"A",$arr,$i);
            $arr=str_replace(array("eu", "ue"),"B",$arr,$i);
            $arr=str_replace(array("ev", "ve"),"C",$arr,$i);
            $arr=str_replace(array("ff", "ff"),"D",$arr,$i);
            $arr=str_replace(array("gf", "fg"),"E",$arr,$i);
            //$arr=str_replace(array("fh", "hf"),"F",$arr,$i);
            $arr=str_replace(array("if", "fi"),"G",$arr,$i);
            $arr=str_replace(array("jf", "fj"),"H",$arr,$i);
            $arr=str_replace(array("fk", "kf"),"I",$arr,$i);
            //$arr=str_replace(array("gr", "rg"),"J",$arr,$i);
            $arr=str_replace(array("mf", "fm"),"K",$arr,$i);
            $arr=str_replace(array("fn", "nf"),"L",$arr,$i);
            $arr=str_replace(array("fo", "of"),"M",$arr,$i);
            $arr=str_replace(array("fp", "pf"),"N",$arr,$i);
            $arr=str_replace(array("qf", "fq"),"O",$arr,$i);
            $arr=str_replace(array("rf", "fr"),"P",$arr,$i);
            //$arr=str_replace(array("gr", "rg"),"Q",$arr,$i);
            $arr=str_replace(array("ft", "tf"),"R",$arr,$i);
            $arr=str_replace(array("uf", "fu"),"S",$arr,$i);
            $arr=str_replace(array("fv", "vf"),"T",$arr,$i);
            //$arr=str_replace(array("hu", "uh"),"U",$arr,$i);
            $arr=str_replace(array("gg", "gg"),"V",$arr,$i);
            //$arr=str_replace(array("gr", "rg"),"W",$arr,$i);
            //$arr=str_replace(array("gr", "rg"),"X",$arr,$i);
            //$arr=str_replace(array("gr", "rg"),"Y",$arr,$i);
            //$arr=str_replace(array("gr", "rg"),"Z",$arr,$i);
            //Numero
            $arr=str_replace(array("dt", "td"),"0",$arr,$i);
            $arr=str_replace(array("ud", "du"),"1",$arr,$i);
            $arr=str_replace(array("vd", "dv"),"2",$arr,$i);
            $arr=str_replace(array("fe", "ef"),"3",$arr,$i);
            $arr=str_replace(array("ge", "eg"),"4",$arr,$i);
            $arr=str_replace(array("eh", "he"),"5",$arr,$i);
            $arr=str_replace(array("ie", "ei"),"6",$arr,$i);
            $arr=str_replace(array("je", "ej"),"7",$arr,$i);
            $arr=str_replace(array("ek", "ke"),"8",$arr,$i);
            $arr=str_replace(array("le", "el"),"9",$arr,$i);
            //Carractaire speciaux
            $arr=str_replace(array("uc", "cu"),"&nbsp;",$arr,$i);
            $arr=str_replace(array("dr", "rd"),".",$arr,$i);
            $arr=str_replace(array("gd", "dg"),"#",$arr,$i);
            $arr=str_replace(array("do", "od"),"+",$arr,$i);
            $arr=str_replace(array("me", "em"),":",$arr,$i);
            $arr=str_replace(array("dp", "pd"),"|",$arr,$i);
            $arr=str_replace(array("dm", "md"),")",$arr,$i);
            $arr=str_replace(array("ld", "dl"),"(",$arr,$i);
            $arr=str_replace(array("en", "ne"),";",$arr,$i);
            $arr=str_replace(array("qd", "dq"),"-",$arr,$i);
            $arr=str_replace(array("es", "se"),"@",$arr,$i);
            $arr=str_replace(array("pe", "ep"),"=",$arr,$i);
            $arr=str_replace(array("dn", "nd"),"*",$arr,$i);
            $arr=str_replace(array("re", "er"),"?",$arr,$i);
            $arr=str_replace(array('fd', 'df'),'"',$arr,$i);
            $arr=str_replace(array("gp", "pg"),"_",$arr,$i);
            $arr=str_replace(array("oe", "eo"),"<",$arr,$i);
            $arr=str_replace(array("eq", "qe"),">",$arr,$i);
        
            $html = null;
            $data = '';
            foreach($arr as $element)
            {
                $html .= $element;
            }

           
        
            $bodytag = str_replace("|", "<br>", $html);
            $bodytag = str_replace(");", ");<br>", $bodytag);
            $bodytag = str_replace(";&nbsp;", ";<br>", $bodytag);
        
            $listes = explode("<br>", $bodytag);

            return $listes;
        

    }
}
