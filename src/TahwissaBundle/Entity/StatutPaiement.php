<?php
/**
 * Created by PhpStorm.
 * User: esprit
 * Date: 08/02/2017
 * Time: 23:41
 */

namespace TahwissaBundle\Entity;


abstract class StatutPaiement
{
    const __default = "EN_ATTENTE";
    const EN_ATTENTE = "EN_ATTENTE";
    const REMBOURSE = "REMBOURSE";
    const EFFECTUE = "EFFECTUE";
}