<?php

namespace App\ClassMain;

use App\Entity\Produits;

class TextEmailProduit
{

    private $produits;
    
    public function __construct(array $produits)
    {
        $this->produits = $produits;
    }

    public function startHtml() {
        if(empty($this->produits)) {
            return "";
        }
        $text = '<style>'."\n";
        $text .= 'table, th, td {'."\n";
        $text .= 'border: 1px solid;'."\n";
        $text .= 'padding: 5px;'."\n";
        $text .= '}'."\n";
        $text .= 'table th {'."\n";
        $text .= 'background-color: lightcyan;'."\n";
        $text .= '}'."\n";
        $text .= 'table {'."\n";
        $text .= 'border-collapse: collapse;'."\n";
        $text .= '}'."\n";
        $text .= '</style>'."\n";
        $text .= '<p>'."\n";
        $text .= 'Bonjour,<br />'."\n";
        $text .= '</p>'."\n";
        return $text;
    }

    public function startText() {
        if(empty($this->produits)) {
            return "";
        }
        $text = 'Bonjour,'."\n";
        return $text;
    }

    public function endHtml() {
        if(empty($this->produits)) {
            return "";
        }
        $text = '<p>'."\n";
        $text .= 'Cordialement.<br />'."\n";
        $text .= '</p>'."\n";
        return $text;
    }

    public function endText() {
        if(empty($this->produits)) {
            return "";
        }
        $text = 'Cordialement.<br />';
        $text .= "\n";
        return $text;
    }

    public function Tablehtml(bool $before = false)
    {
        if(empty($this->produits)) {
            return "";
        }
        $text = '<p>'."\n";
        if(!$before) {
            $text .= 'C\'est la fin de la garantie pour les produits suivants  :<br />'."\n";
        } else {
            $text .= 'C\'est bientôt la fin de la garantie pour les produits suivants :<br />'."\n";
        }
        $text .= '</p>'."\n";
        $text .= '<table>'."\n";
        $text .= '<thead>'."\n";
        $text .= '<tr>'."\n";
        $text .= '<th>Id</th>'."\n";
        $text .= '<th>Nom</th>'."\n";
        $text .= '<th>Slug</th>'."\n";
        $text .= '<th>Date d\'achat</th>'."\n";
        $text .= '<th>Date de fin de garantie</th>'."\n";
        $text .= '<th>Prix</th>'."\n";
        $text .= '<th>Visible</th>'."\n";
        $text .= '<th>Date de création</th>'."\n";
        $text .= '</tr>'."\n";
        $text .= '</thead>'."\n";
        $text .= '<tbody>'."\n";
        foreach ($this->produits as $produit) {
            $text .= '<tr>'."\n";
            $text .= '<td>'.$produit->getId().'</td>'."\n";
            $text .= '<td>'.$produit->getName().'</td>'."\n";
            $text .= '<td>'.$produit->getSlug().'</td>'."\n";
            $text .= '<td>'.$produit->getAchatAt()->format('d/m/Y').'</td>'."\n";
            $text .= '<td>'.$produit->getGuaranteeAt()->format('d/m/Y').'</td>'."\n";
            $text .= '<td>'.$produit->getPrice().' €</td>'."\n";
            $text .= '<td>'.($produit->isActive() ? "oui" : "non").'</td>'."\n";
            $text .= '<td>'.$produit->getCreatedAt()->format('d/m/Y').'</td>'."\n";
            $text .= '</tr>'."\n";
        }
        $text .= '</tbody>'."\n";
        $text .= '</table>'."\n";
        return $text;
    }

    public function tableText(bool $before = false)
    {
        if(empty($this->produits)) {
            return "";
        }
        $text = '';
        if(!$before) {
            $text .= 'C\'est la fin de la garantie pour les produits suivants :'."\n";
        } else {
            $text .= 'C\'est bientôt la fin de la garantie pour les produits suivants :'."\n";
        }
        $text .= 'Id;';
        $text .= 'Nom;';
        $text .= 'Slug;';
        $text .= 'Date d\'achat;';
        $text .= 'Date de fin de garantie;';
        $text .= 'Prix;';
        $text .= 'Visible;';
        $text .= 'Date de création;';
        $text .= "\n";
        foreach ($this->produits as $produit) {
            $text .= $produit->getId().';';
            $text .= $produit->getName().';';
            $text .= $produit->getSlug().';';
            $text .= $produit->getAchatAt()->format('d/m/Y').';';
            $text .= $produit->getGuaranteeAt()->format('d/m/Y').';';
            $text .= $produit->getPrice().' €;';
            $text .= ($produit->isActive() ? "oui" : "non").';';
            $text .= $produit->getCreatedAt()->format('d/m/Y').';';
            $text .= "\n";
        }
        return $text;
    }

}