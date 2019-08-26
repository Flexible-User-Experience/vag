<?php

namespace App\Admin;

use App\Entity\Media;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

/**
 * Class MediaAdmin
 */
final class MediaAdmin extends AbstractAdmin
{
    /**
     * @var string
     */
    protected $classnameLabel = 'admin.class.media';

    /**
     * @var string
     */
    protected $baseRoutePattern = 'configuracio/media';

    /**
     * @var array
     */
    protected $datagridValues = array(
        '_sort_by' => 'name',
        '_sort_order' => 'ASC',
    );

    /**
     * Methods.
     */

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('admin.with.media', ['class' => 'col-md-4'])
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'admin.label.name',
                ]
            )
            ->add(
                'description',
                TextType::class,
                [
                    'label' => 'admin.label.description',
                    'required' => false,
                ]
            )
            ->end()
        ;
        if ($this->formBuilderIsInEditMode()) {
            $formMapper
                ->with('admin.with.images', ['class' => 'col-md-4'])
                ->add(
                    'imageFile',
                    FileType::class,
                    [
                        'label' => 'admin.label.image',
                        'help' => $this->getImageHelperFormMapperWithThumbnail(),
                        'required' => false,
                    ]
                )
                ->end()
            ;
        }
        $formMapper
            ->with('admin.with.controls', ['class' => 'col-md-4'])
            ->add(
                'slug',
                TextType::class,
                [
                    'label' => 'admin.label.slug',
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->add(
                'link',
                UrlType::class,
                [
                    'label' => 'admin.label.link',
                    'required' => false,
                    'disabled' => true,
                ]
            )
            ->end()
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'name',
                null,
                [
                    'label' => 'admin.label.name',
                ]
            )
            ->add(
                'description',
                null,
                [
                    'label' => 'admin.label.description',
                ]
            )
            ->add(
                'link',
                null,
                [
                    'label' => 'admin.label.link',
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add(
                'image',
                null,
                array(
                    'label' => 'admin.label.single_image',
                    'template' => 'backend/cells/list__cell_file_or_image_field.html.twig',
                )
            )
            ->add(
                'name',
                null,
                [
                    'label' => 'admin.label.name',
                    'editable' => true,
                ]
            )
            ->add(
                'link',
                null,
                [
                    'label' => 'admin.label.link',
                    'editable' => false,
                ]
            )
            ->add(
                '_action',
                null,
                [
                    'label' => 'admin.label.actions',
                    'actions' => [
                        'edit' => [],
                    ],
                ]
            )
        ;
    }

    /**
     * @param Media $object
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function postUpdate($object)
    {
        parent::postUpdate($object);
        $extension = $this->vufs->getFileExtension($object, 'imageFile');
        if ($this->vufs->isImageFileExtension($extension)) {
            $object->setLink($this->vufs->getImageFileSrcWithLiipFilter($object, 'imageFile', '1200xY'));
        } else {
            $object->setLink($this->vufs->getFileSrc($object, 'imageFile'));
        }
        $this->em->flush();
    }
}
