<?php

namespace ATManager\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ATManager\BackendBundle\Entity\Sector;
use ATManager\BackendBundle\Form\SectorType;
use ATManager\BackendBundle\Form\BuscadorType; 

class SectorController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form=$this->createForm(new BuscadorType(),null,array('method' => 'GET'));
        $form->handleRequest($request);
        $entities =array();
        if ($form->isValid()) {
            $nombre=$form->get('nombre')->getData();
            $entities = $em->getRepository('BackendBundle:Sector')->findByName($nombre);
        }
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate($entities, $this->getRequest()->query->get('pagina',1), 10);
        return $this->render('BackendBundle:Sector:index.html.twig',array(
            'entities' => $entities,
            'form'=>$form->createView()
             ));
    }
    public function newAction()
    {
        $entity = new Sector();
        $form = $this->createForm(new SectorType(), $entity);
        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            try{
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item Guardado');
                return $this->redirect($this->generateUrl('sector_show', array('id' => $entity->getId())));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar agregar item');
             //   return $this->redirect($this->generateUrl('sector_new'));
            }
        }
        return $this->render('BackendBundle:Sector:new.html.twig',array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Sector')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sector entity.');
        }
        return $this->render('BackendBundle:Sector:show.html.twig', 
            array('entity' => $entity)
        );
    }
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BackendBundle:Sector')->find($id);
        $editForm =  $this->createForm(new SectorType(), $entity);
	$editForm->handleRequest($this->getRequest());
	if ($editForm->isValid()) {
            try{
		$em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','Item actualizado');
                return $this->redirect($this->generateUrl('sector_edit', array('id' => $id)));
            }
            catch(\Exception $e){
                $this->get('session')->getFlashBag()->add('error','Error al intentar actualizar item');
            //    return $this->redirect($this->generateUrl('sector_edit', array('id' => $id)));
            }
        }
        return $this->render('BackendBundle:Sector:edit.html.twig',array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        ));
    }
    public function eliminarAction($id)
    {                
        try{
            $em = $this->getDoctrine()->getManager();
            $objs = $em->getRepository('BackendBundle:Sector')->find($id);
            $em->remove($objs); 
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Item Eliminado');
            return $this->redirect($this->generateUrl('sector_listado'));

        }catch(\Exception $e) {
            $this->get('session')->getFlashBag()->add('error','Error al intentar eliminar item');
            return $this->redirect($this->generateUrl('sector_listado'));
        }     
    }
}
