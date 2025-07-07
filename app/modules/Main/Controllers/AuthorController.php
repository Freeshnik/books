<?php

namespace Main\Controllers;

use App\App;
use App\Controller\MainController;
use App\Forms\Author\AuthorForm;
use App\Models\Author;
use App\Models\AuthorSearch;
use App\Models\Book;
use App\Models\User;
use App\Repositories\Author\AuthorRepo;
use DomainException;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * AuthorController implements the CRUD actions for Author model.
 */
class AuthorController extends MainController
{
    public function __construct(
        $id,
        $module,
        private readonly AuthorRepo $authorRepo,
        array $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    /**
     * Lists all Author models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new AuthorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $canManage = !Yii::$app->user->isGuest && Yii::$app->user->identity->type === User::TYPE_USER;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'canManage' => $canManage,
        ]);
    }

    /**
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        $canManage = !Yii::$app->user->isGuest && Yii::$app->user->identity->type === User::TYPE_USER;

        $author = $this->authorRepo->findOneByConditions(Author::class, ['id' => $id]);
        if (!$author) {
            throw new NotFoundHttpException('Author not found.');
        }

        return $this->render('view', [
            'model' => $author,
            'canManage' => $canManage,
        ]);
    }

    /**
     * Creates a new Author model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return Response|string
     * @throws Exception
     */
    public function actionCreate(): Response|string
    {
        $authorForm = new AuthorForm();

        if ($this->request->getIspost() && $authorForm->load($this->request->post()) && $authorForm->validate()) {
            $authorId = $this->authorRepo->create($authorForm);
            if ($authorId) {
                return $this->redirect(['view', 'id' => $authorId]);
            }
        }

        return $this->render('create', [
            'model' => $authorForm,
        ]);
    }

    /**
     * Updates an existing Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     * @return Response|string
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id): Response|string
    {
        /** @var Author $author */
        $author = $this->authorRepo->findOneByConditions(Author::class, ['id' => $id]);
        if (!$author) {
            throw new NotFoundHttpException('Author not found.');
        }

        $form = new AuthorForm($author);

        if ($this->request->getIspost() && $form->load($this->request->post(), 'AuthorForm') && $form->validate()) {
            $author->setAttributes($form->getAttributes(), false);
            /** @var Author $author */
            $author = $this->authorRepo->update($author);

            return $this->redirect(['view', 'id' => $author->id]);
        }

        return $this->render('update', [
            'model' => $form,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function actionDelete(int $id): Response
    {
        try {
            $this->authorRepo->delete(Author::class, $id);
        } catch (DomainException $e) {
            Yii::$app->errorHandler->logException($e);
        }

        return $this->redirect(['index']);
    }
}
