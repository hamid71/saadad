<?php

namespace App\Controller;
 use App\Entity\Software;
 use App\Entity\Discipline;
 use App\Entity\Invoice;
 use App\Entity\Types;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\Routing\Annotation\Route;
 use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use Symfony\Component\HttpFoundation\File\File;
 use Symfony\Component\Form\Extension\Core\Type\TextType;
 use Symfony\Component\Form\Extension\Core\Type\TextareaType;
 use Symfony\Component\Form\Extension\Core\Type\IntegerType;
 use Symfony\Component\Form\Extension\Core\Type\MoneyType;
 use Symfony\Component\Form\Extension\Core\Type\EmailType;
 use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
 use Symfony\Component\Form\Extension\Core\Type\DateType;
 use Symfony\Component\Form\Extension\Core\Type\FileType;
 use Symfony\Bridge\Doctrine\Form\Type\EntityType;
 use Symfony\Component\Form\Extension\Core\Type\SubmitType;
 use Knp\Component\Pager\PaginatorInterface;
 use Symfony\Component\HttpFoundation\StreamedResponse;

class SoftwareController extends Controller
{
    /**
    * @Route("/", name="software_list")
    * @Method({"GET"})
    */
    public function software(Request $request)
    {
        $softwares = $this->getDoctrine()->getManager();
        $queryBuilder = $softwares->getRepository('App:Software')->createQueryBuilder('bp');
            if ($request->query->getAlnum('filter')) 
                {
                    $queryBuilder->where('bp.id LIKE :name')
                    ->setParameter('name', '%' . $request->query->getAlnum('filter') . '%');
                }
        $query = $queryBuilder->getQuery();
        $paginator  = $this->get('knp_paginator');
        
        $pages = $request->query->getInt('pages');
        //Select how many rows per page to show
            if($pages == 3)
            { dump($pages);
                $results = $paginator->paginate(
                    $query, /* query NOT result */
                    $request->query->getInt('page', 1)/*page number*/,
                    $request->query->getInt('limit',3)/*limit per page*/
                );
                return $this->render('softwares/index.html.twig', [
                    'softwares' => $results,
                ]);
            } 
            
           if($pages  == 4)
           {dump($pages);
            $results = $paginator->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                $request->query->getInt('limit',4)/*limit per page*/
            );
            return $this->render('softwares/index.html.twig', [
                'softwares' => $results,
            ]);
           }
            
            if($pages  == 5)
            {dump($pages);
                $results = $paginator->paginate(
                    $query, /* query NOT result */
                    $request->query->getInt('page', 1)/*page number*/,
                    $request->query->getInt('limit',5)/*limit per page*/
                );
                return $this->render('softwares/index.html.twig', [
                    'softwares' => $results,
                ]);
            }
            $results = $paginator->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                $request->query->getInt('limit',500)/*limit per page*/
            );
            return $this->render('softwares/index.html.twig', [
                'softwares' => $results,
            ]);    
            
    }

    /**
     * @Route("/software/discipline", name="discipline")
     * @Method({"GET", "POST"})
     */
      public function newDiscipline(Request $request)
    {
        
        $discipline = new Discipline();
        
        $form = $this->createFormBuilder($discipline)
        ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array('label' => 'Create','attr' => array('class'=>'brn btn-primary mt-3')))
        ->getForm();
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

            $discipline = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($discipline);
            $entityManager->flush();
            return $this->redirectToRoute('discipline');
            
        }
        return $this->render('softwares/discipline.html.twig', array('form' => $form->createView()));

    }
   
    /**
    * @Route("/software/type", name="type")
    * @Method({"GET", "POST"})
    */
    public function newType(Request $request)
    {
        
        $type = new Types();
        
        $form = $this->createFormBuilder($type)
        ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array('label' => 'Create','attr' => array('class'=>'brn btn-primary mt-3')))
        ->getForm();
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

            $type = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($type);
            $entityManager->flush();
            return $this->redirectToRoute('type');
            
        }
        return $this->render('softwares/type.html.twig', array('form' => $form->createView()));

    }
    // Add new user
    /**
    * @Route("/software/new", name="new_software")
    * @Method({"GET", "POST"})
    */
    public function new(Request $request)
    {
        $discipline= new Discipline();
        $software = new Software();
        $type = new Types();
        $form = $this->createFormBuilder($software)
        ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('version', TextType::class, array('attr' => array('class'=>'form-control')))
        ->add('cost', IntegerType::class, array('attr' => array('class'=>'form-control')))
        ->add('description', TextType::class, array('attr' => array('class'=>'form-control')))
        ->add('datepurchase', DateType::class, array('attr' => array('class'=>'form-control')))
        ->add('expiredate', DateType::class, array('attr' => array('class'=>'form-control')))
        ->add('requiredby',TextType::class, array('attr' => array('class'=>'form-control')))
        ->add('contact', EmailType::class, array('attr' => array('class'=>'form-control')))
        ->add('free', ChoiceType::class, array('choices' => array('Yes' => 'yes','No' => 'no'),'placeholder' => 'Choose an option'))
        ->add('scemlab', ChoiceType::class, array('choices' => array('Yes' => 'yes','No' => 'no'),'placeholder' => 'Choose an option'))
        ->add('scemlic', ChoiceType::class, array('choices' => array('Yes' => 'yes','No' => 'no'),'placeholder' => 'Choose an option'))
        ->add('floating', ChoiceType::class, array('choices' => array('Yes' => 'yes','No' => 'no'),'placeholder' => 'Choose an option'))
        ->add('vendor', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('cost_Centre', IntegerType::class, array('attr' => array('class'=>'form-control')))
        ->add('remark', TextareaType::class, array('attr' => array('class' => 'form-control')))
        ->add('Type', EntityType::class, array('class' => Types::class,'choices' => $type->getName(),))
        ->add('invoice', FileType::class, array('required' => false,'label' => 'Invoice (PDF)'))
        ->add('quatation', FileType::class, array('required' => false,'label' => 'Qutation (PDF)'))
        ->add('purchesorder', FileType::class, array('required'=> false,'label' => 'PurchesOrder (PDF)'))
        ->add('discipline', EntityType::class, array('class' => Discipline::class,'choices' => $discipline->getName(),))
        ->add('save', SubmitType::class, array('label' => 'Create','attr' => array('class'=>'brn btn-primary mt-3')))
        ->getForm();

        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            if($file = $form->get('invoice')->getData())
            {
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('invoices_directory'),
                    $fileName
                    );
                    $software->setInvoice($fileName);
            }
            
            if($file1 = $form->get('quatation')->getData())
            {
                $fileName1 = $this->generateUniqueFileName().'.'.$file1->guessExtension();
                $file1->move(
                    $this->getParameter('quatations_directory'),
                    $fileName1
                    );
                    $software->setQuatation($fileName1);
            }
            if($file2 = $form->get('purchesorder')->getData())
            {
                $fileName2 = $this->generateUniqueFileName().'.'.$file2->guessExtension(); 
                $file2->move(
                    $this->getParameter('purchesorders_directory'),
                    $fileName2
                    );
                    $software->setPurchesorder($fileName2);
            }
            $software = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($software);
            $entityManager->flush();
            return $this->redirectToRoute('software_list');
            
        }
        return $this->render('softwares/new.html.twig', array('form' => $form->createView()));
    }

    // Update software information
    /**
    * @Route("/software/edit/{id}", name="edit_software")
    * @Method({"GET", "POST"})
    */
    public function edit(Request $request, $id)
    {
            
        $discipline= new Discipline();
        $software = new Software();
        $type = new Types();
        $software = $this-> getDoctrine()->getRepository
        (Software::class)->find($id);
        $form = $this->createFormBuilder($software)
        ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('version', TextType::class, array('attr' => array('class'=>'form-control')))
        ->add('cost', IntegerType::class, array('attr' => array('class'=>'form-control')))
        ->add('description', TextType::class, array('attr' => array('class'=>'form-control')))
        ->add('datepurchase', DateType::class, array('attr' => array('class'=>'form-control')))
        ->add('expiredate', DateType::class, array('attr' => array('class'=>'form-control')))
        ->add('requiredby',TextType::class, array('attr' => array('class'=>'form-control')))
        ->add('contact', EmailType::class, array('attr' => array('class'=>'form-control')))
        ->add('free', ChoiceType::class, array('choices' => array('Yes' => 'yes','No' => 'no'),'placeholder' => 'Choose an option'))
        ->add('scemlab', ChoiceType::class, array('choices' => array('Yes' => 'yes','No' => 'no'),'placeholder' => 'Choose an option'))
        ->add('scemlic', ChoiceType::class, array('choices' => array('Yes' => 'yes','No' => 'no'),'placeholder' => 'Choose an option'))
        ->add('floating', ChoiceType::class, array('choices' => array('Yes' => 'yes','No' => 'no'),'placeholder' => 'Choose an option'))
        ->add('vendor', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('cost_Centre', IntegerType::class, array('attr' => array('class'=>'form-control')))
        ->add('remark', TextareaType::class, array('attr' => array('class' => 'form-control')))
        ->add('Type', EntityType::class, array('class' => Types::class,'choices' => $type->getName(),))
        ->add('invoice', FileType::class, array('data_class' => null,'required' => false,'label' => 'Invoice (PDF)'))
        ->add('quatation', FileType::class, array('data_class' => null,'required' => false,'label' => 'Qutation (PDF)'))
        ->add('purchesorder', FileType::class, array('data_class' => null,'required'=> false,'label' => 'PurchesOrder (PDF)'))
        ->add('discipline', EntityType::class, array('class' => Discipline::class,'choices' => $discipline->getName(),))
        ->add('save', SubmitType::class, array('label' => 'Update','attr' => array('class'=>'brn btn-primary mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            if($file = $form->get('invoice')->getData())
            {
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('invoices_directory'),
                    $fileName
                    );
                    $software->setInvoice($fileName);
            }
            
            if($file1 = $form->get('quatation')->getData())
            {
                $fileName1 = $this->generateUniqueFileName().'.'.$file1->guessExtension();
                $file1->move(
                    $this->getParameter('quatations_directory'),
                    $fileName1
                    );
                    $software->setQuatation($fileName1);
            }
            if($file2 = $form->get('purchesorder')->getData())
            {
                $fileName2 = $this->generateUniqueFileName().'.'.$file2->guessExtension(); 
                $file2->move(
                    $this->getParameter('purchesorders_directory'),
                    $fileName2
                    );
                    $software->setPurchesorder($fileName2);
                     
            } 
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('software_list');
        }
        return $this->render('softwares/edit.html.twig', array('form' => $form->createView()));
    }
    
    // Delete selected software
    /**
    * @Route("/software/delete/{id}")
    * @Method({"DELETE"})
    */
    public function delete(Request $request, $id) 
    {
        $software = $this->getDoctrine()->getRepository(Software::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($software);
        $entityManager->flush();
        $response = new Response();
        $response->send();
    }
    
    // Logout function
    /**
    * @Route("/logout", name="logout")
    */
    public function logout()
    {

    }
    
    // Show slected row filtered by date, type, discipline or any combination and allow user to export csv file
    /**
    * @Route("/costByDate", name="costByDate")
    * @Method({"GET"})
    */
    public function costByDate(Request $request)
    {
        $type = $request->query->getAlnum('type');
        $discipline = $request->query->getAlnum('discipline');
        dump($discipline);
        $fromDate = $request->query->getAlnum('from');
        $fromDate = date('Y-m-d', strtotime(str_replace('-', '/', $fromDate)));
        $toDate = $request->query->getAlnum('to');
        $toDate = date('Y-m-d', strtotime(str_replace('-', '/', $toDate)));
        if($toDate == "1970-01-01") 
           {
               $toDate = (new \DateTime("now"));
           } 
        if($request->query->getAlnum('find')=='export')
        { 
            $softwares = $this->getDoctrine()->getManager();
            $queryBuilder = $softwares->getRepository('App:Software')->createQueryBuilder('bp');
                {
                    $queryBuilder
                    ->select('bp, l')
                    ->leftJoin('bp.Type', 'l')
                    ->where('l.name LIKE :Type')
                    ->select('bp, q')
                    ->leftJoin('bp.discipline', 'q')
                    ->andWhere('q.name LIKE :discipline')
                    ->setParameter('Type', '%' . $type . '%')
                    ->setParameter('discipline', '%' . $discipline . '%')
                    ->andWhere('bp.datepurchase BETWEEN :from AND :to')
                    ->setParameter('from', $fromDate )
                    ->setParameter('to', $toDate );
                }
               
            $query = $queryBuilder->getQuery();
        
            $paginator  = $this->get('knp_paginator');
        
            $pages = $request->query->getInt('pages');
        
            {
                $results = $paginator->paginate
                (
                    $query, /* query NOT result */
                    $request->query->getInt('page', 1)/*page number*/,
                    $request->query->getInt('limit',100)/*limit per page*/
                );
            };

            $response = new StreamedResponse();
            // dump($queryBuilder);
            $response->setCallback
            (
                function () use ($results) 
                {
                    $handle = fopen('php://output', 'r+');
                    fputcsv($handle, array('Discipline Name','Type','Cost','Cost Centre', 'Purchase Date', 'Expire Date' ));
                    foreach ($results as $software) 
                    {
                        //array list fields you need to export
                        $data = array(
                            $software->getDiscipline(),
                            $software->getType(),
                            $software->getCost(),
                            $software->getCostCentre(),
                            $software->getDatepurchase()->format('Y-m-d'),
                            $software->getExpiredate()->format('Y-m-d'),
                        );    
                        fputcsv($handle, $data);
                    }
                    fclose($handle);    
                }
            );
            $response->headers->set('Discipline', 'application/force-download');
            $response->headers->set('Content-Disposition', 'attachment; filename="export.csv"');
                return $response;
        }
        
            $softwares = $this->getDoctrine()->getManager();
            $queryBuilder = $softwares->getRepository('App:Software')->createQueryBuilder('bp');
                {
                    $queryBuilder
                    ->select('bp, l')
                    ->leftJoin('bp.Type', 'l')
                    ->where('l.name LIKE :Type')
                    ->select('bp, q')
                    ->leftJoin('bp.discipline', 'q')
                    ->andWhere('q.name LIKE :discipline')
                    ->setParameter('Type', '%' . $type . '%')
                    ->setParameter('discipline', '%' . $discipline . '%')
                    ->andWhere('bp.datepurchase BETWEEN :from AND :to')
                    ->setParameter('from', $fromDate )
                    ->setParameter('to', $toDate );
                }
            $query = $queryBuilder->getQuery();
        
            $paginator  = $this->get('knp_paginator');
        
            $pages = $request->query->getInt('pages');
        
            {
                $results = $paginator->paginate
                (
                    $query, /* query NOT result */
                    $request->query->getInt('page', 1)/*page number*/,
                    $request->query->getInt('limit',100)/*limit per page*/
                );
            };
  
            return $this->render('softwares/showByDate.html.twig', [
                'softwares' => $results,]);            
    }
    
}