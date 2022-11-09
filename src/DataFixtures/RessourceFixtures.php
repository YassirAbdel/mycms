<?php

namespace App\DataFixtures;
ini_set('memory_limit', '-1');
use App\Entity\Ressource;
use App\Repository\RessourceRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use League\Csv\Reader;
use League\Csv\Statement;
use PhpParser\Node\Stmt;

class RessourceFixtures extends Fixture
{
    private $repository; 
    
    public function __construct(RessourceRepository $repository) 
    {
        $this->repository = $repository;
    }

    public function load(ObjectManager $om): void
    {
        $stream = fopen('/Users/abdelmontet/Documents/http/mycms/import/pho_doc.csv', 'r');
        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        $stmt = new Statement();
        $stmt->offset(10)->limit(25);

        $records = $stmt->process($csv);

        $size = count($records);
        $batch_size = 20;
        $i = 1; 

        foreach ($records as $record) {
            // On vérifie si la ressource existe
            $compteur = $this->repository->compteByIdcadic($record['DOC_REF']);
            
            // On récupère la ressource
            $results = $this->repository->findByIdcadic($record['DOC_REF']);

            // Si la ressource n'existe pas en crée une nouveau enrigistrement
            if ($compteur < 1) {
                $ressource = new Ressource();
            }

            // Si elle existe, on la met à jour
            else
            {
                foreach ($results as $result) {
                    $ressource = $this->repository->findByDocRef($record['DOC_REF']);
                }
            }
            if (isset($record['DOC_TYPE'])) {
                $ressource->setType($record['DOC_TYPE']);
            }
            if (isset($record['DOC_TITRE'])) {
                $ressource->setTitre($record['DOC_TITRE']);
            }
            if (isset($record['DOC_AUTEUR'])) { 
                $ressource->setAuteur($record['DOC_AUTEUR']);
            }
            if (isset($record['CND_TIT_F'])) { 
                $ressource->setResponsable($record['CND_TIT_F']);
            }
            if (isset($record['DOC_LANGUE'])) { 
                $ressource->setLangue($record['DOC_LANGUE']);
            }
            if (isset($record['DOC_COMMENT'])) { 
                $ressource->setCommentaire($record['DOC_COMMENT']);
            }
            if (isset($record['CND_OEUVRE'])) {
                $ressource->setOeuvre($record['CND_OEUVRE']);
            }
            if (isset($record['DOC_AUTEURSEC'])) {
                $ressource->setAuteurSecondaire($record['DOC_AUTEURSEC']);
            }
            if (isset($record['DOC_AUTMORAL'])) {
                $ressource->setAuteurMoral($record['DOC_AUTMORAL']);
            }
            if (isset($record['PHO_RESP_EDIT'])) {
                $ressource->setResponsableEdition($record['PHO_RESP_EDIT']);
            }
            if (isset($record['DOC_DP'])) {
                $ressource->setAnneeEdition($record['DOC_DP']);
            }
            if (isset($record['DOC_DP_STAT'])) {
                $ressource->setAnneeStat(intval($record['DOC_DP_STAT']));
            }
            if (isset($record['DOC_DEE'])) {
                $ressource->setDescripteur($record['DOC_DEE']);
            }
            if (isset($record['PHO_PERSON'])) {
                $ressource->setPersonne($record['PHO_PERSON']);
            }
            if (isset($record['DOC_GEO'])) {
                $ressource->setLieu($record['DOC_GEO']);
            }
            if (isset($record['PHO_HISTORI'])) {
                $ressource->setPerHisto($record['PHO_HISTORI']);
            }
            if (isset($record['CND_COLL_AU'])) {
                $ressource->setOrganisme($record['CND_COLL_AU']);
            }
            if (isset($record['DOC_COLLECTION'])) {
                $ressource->setCollection($record['DOC_COLLECTION']);
            }
            if (isset($record['PHO_ORIGINE'])) {
                $ressource->setOrigDoc($record['PHO_ORIGINE']);
            }
            if (isset($record['PHO_COPYRIGHT'])) {
                $ressource->setCopyRight($record['PHO_COPYRIGHT']);
            }
            if (isset($record['PHO_DROIT_IMG'])) {
                $ressource->setDroits($record['PHO_DROIT_IMG']);
            }
            if (isset($record['DOC_SUP'])) {
                $ressource->setSupport($record['DOC_SUP']);
            }
            if (isset($record['PHO_COULEUR'])) {
                $ressource->setCouleur($record['PHO_COULEUR']);
            }
            if (isset($record['PHO_FORMAT'])) {
                $ressource->setFormat($record['PHO_FORMAT']);
            }
            if (isset($record['PHO_FORMFILE'])) {
                $ressource->setFormatFile($record['PHO_FORMFILE']);
            }
            if (isset($record['CND_DUREE'])) {
                $ressource->setDuree($record['CND_DUREE']);
            }
            if (isset($record['PHO_NB_DOC'])) {
                $ressource->setNbFiles($record['PHO_NB_DOC']);
            }
            if (isset($record['DOC_COTE'])) {
                $ressource->setCote($record['DOC_COTE']);
            }
            if (isset($record['PHO_NUMCD'])) {
                $ressource->setSupNum($record['PHO_NUMCD']);
            }
            if (isset($record['PHO_LOC_CD'])) {
                $ressource->setLocaSupnum($record['PHO_LOC_CD']);
            }
            if (isset($record['CND_COTE_P'])) {
                $ressource->setCoteNum($record['CND_COTE_P']);
            }
            if (isset($record['AUD_REF'])) {
                $ressource->setUrlAudio($record['AUD_REF']);
            }
            if (isset($record['CND_VIDEO_REF1'])) {
                $ressource->setNumVideo($record['CND_VIDEO_REF1']);
            }
            if (isset($record['CND_URL'])) {
                $ressource->setUrlDoc($record['CND_URL']);
            }
            if (isset($record['DOC_ATTACHE'])) {
               $ressource->setUrlPdf($record['DOC_ATTACHE']);
            }
            if (isset($record['IMG_REF'])) {
                $ressource->setUrlImag($record['IMG_REF']);
            }
            if (isset($record['DOC_REF'])) {
                $ressource->setReferenceCadic($record['DOC_REF']);

            }
            $om->persist($ressource);
            if (($i % $batch_size) === 0) {
                $om->flush();
                $om->clear();
            }
            $i++;
        }
        $om->flush();
        $om->clear();

    }
}
