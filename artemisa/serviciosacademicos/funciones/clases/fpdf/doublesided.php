<?php
require('fpdf.php');

class DoubleSided_PDF extends FPDF
{
    var $doubleSided;    // layout like books?
    var $outerMargin;
    var $innerMargin;
    var $xDelta;         // if double-sided, difference between outer and inner

    function DoubleSided_PDF($orientation='P', $unit='mm', $format='A4')
    {
        $this->FPDF($orientation,$unit,$format);
        $this->doubleSided=false;
        $this->xDelta=0;
        $this->innerMargin=10;
        $this->outerMargin=10;
    }

    function SetDoubleSided($inner=7, $outer=13)
    {
        if($outer != $inner) {
            $this->doubleSided=true;
            $this->outerMargin=$outer;
            $this->innerMargin=$inner;
        }
    }

    function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        //Output a cell
        $k=$this->k;
        if($this->y+$h>$this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak())
        {
            //Automatic page break
            $x=$this->x;
            $ws=$this->ws;
            if($ws>0)
            {
                $this->ws=0;
                $this->_out('0 Tw');
            }
            $this->AddPage($this->CurOrientation,$this->CurPageFormat);
            $this->x=$x+$this->xDelta;
            if($ws>0)
            {
                $this->ws=$ws;
                $this->_out(sprintf('%.3F Tw',$ws*$k));
            }
        }
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $s='';
        if($fill || $border==1)
        {
            if($fill)
                $op=($border==1) ? 'B' : 'f';
            else
                $op='S';
            $s=sprintf('%.2F %.2F %.2F %.2F re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
        }
        if(is_string($border))
        {
            $x=$this->x;
            $y=$this->y;
            if(strpos($border,'L')!==false)
                $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
            if(strpos($border,'T')!==false)
                $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
            if(strpos($border,'R')!==false)
                $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
            if(strpos($border,'B')!==false)
                $s.=sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
        }
        if($txt!=='')
        {
            if($align=='R')
                $dx=$w-$this->cMargin-$this->GetStringWidth($txt);
            elseif($align=='C')
                $dx=($w-$this->GetStringWidth($txt))/2;
            else
                $dx=$this->cMargin;
            if($this->ColorFlag)
                $s.='q '.$this->TextColor.' ';
            $txt2=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
            $s.=sprintf('BT %.2F %.2F Td (%s) Tj ET',($this->x+$dx)*$k,($this->h-($this->y+.5*$h+.3*$this->FontSize))*$k,$txt2);
            if($this->underline)
                $s.=' '.$this->_dounderline($this->x+$dx,$this->y+.5*$h+.3*$this->FontSize,$txt);
            if($this->ColorFlag)
                $s.=' Q';
            if($link)
                $this->Link($this->x+$dx,$this->y+.5*$h-.5*$this->FontSize,$this->GetStringWidth($txt),$this->FontSize,$link);
        }
        if($s)
            $this->_out($s);
        $this->lasth=$h;
        if($ln>0)
        {
            //Go to next line
            $this->y+=$h;
            if($ln==1)
                $this->x=$this->lMargin;
        }
        else
            $this->x+=$w;
    }

    function _beginpage($orientation, $format)
    {
        parent::_beginpage($orientation,$format);
        if ( $this->doubleSided ) {
            if( $this->page % 2 == 0 ) {
                $this->xDelta=$this->outerMargin - $this->innerMargin;
                $this->SetLeftMargin($this->outerMargin);
                $this->SetRightMargin($this->innerMargin);
            } else {
                $this->xDelta=$this->innerMargin - $this->outerMargin;
                $this->SetLeftMargin($this->innerMargin);
                $this->SetRightMargin($this->outerMargin);
            }
            $this->x=$this->lMargin;
            $this->y=$this->tMargin;
        }
    }
}
?>
