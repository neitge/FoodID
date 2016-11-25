<?php



namespace One\PlatformBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use One\PlatformBundle\Entity\Advert;
use One\PlatformBundle\Entity\Image;

class AdvertController extends Controller
{
 
    
    
    
    
    
    public function indexAction($page)
  {
    if ($page < 1) {
        $page=1;
    }
    // Notre liste d'annonce en dur
    $listAdverts = array(
      array(
        'title'   => 'Recherche développpeur Symfony',
        'id'      => 1,
        'author'  => 'Clem',
        'content' => 'Plat du jour',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Cuisinier',
        'id'      => 2,
        'author'  => 'Reda',
        'content' => 'Recherche travail',
        'date'    => new \Datetime()),
      array(
        'title'   => 'Cherche cuisine',
        'id'      => 3,
        'author'  => 'Henry',
        'content' => 'Cherche Commis',
        'date'    => new \Datetime())
    );
    return $this->render('OnePlatformBundle:Advert:index.html.twig', array(
      'listAdverts' => $listAdverts,
    ));
  }
    
    public function viewAction()
  {
    $em = $this->getDoctrine()->getManager();
    $advert = $em->getRepository('OnePlatformBundle:Advert')->find($id);
    if (null === $advert)
      {
      throw new NotFoundHttpException("Le plat d'id " . $id . " n'existe pas.");
      }
    return $this->render('OnePlatformBundle:Advert:view.html.twig', array(
      'advert' => $advert,
    ));
  }
    
    
    
  public function menuAction()
  {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $listAdverts = array(
      array('id' => 2, 'title' => 'Recherche développeur Symfony'),
      array('id' => 5, 'title' => 'Mission de webmaster'),
      array('id' => 9, 'title' => 'Offre de stage webdesigner')
    );

    return $this->render('OnePlatformBundle:Advert:menu.html.twig', array(
      // Tout l'intérêt est ici : le contrôleur passe
      // les variables nécessaires au template !
      'listAdverts' => $listAdverts
    ));
  }
    
   public function addAction(Request $request)
    {
        // Création de l'entité Advert
        $advert = new Advert();
        $advert->setTitle('Recherche développeur Symfony.');
        $advert->setAuthor('Alexandre');
        $advert->setContent("Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…");

        // Création de l'entité Image
        $image = new Image();
        $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
        $image->setAlt('Job de rêve');

        // On lie l'image à l'annonce
        $advert->setImage($image);

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité
        $em->persist($advert);

        // Étape 1 bis : si on n'avait pas défini le cascade={"persist"},
        // on devrait persister à la main l'entité $image
        // $em->persist($image);

        // Étape 2 : On déclenche l'enregistrement
        $em->flush();
    }
}