@include(
    'components.datatable.table',
    [
        'title' => 'Users',
      'id' => 'users-datatable',
      'itemsRoute' => 'users.items',
      'heads' => [
          'ID',
            'Name',
            'Email',
            'Role',
            'Organization',
            'Created At',
            'Action'
      ],
      'paginate' => $paginate,
      'dataBlade' => 'panel.users.list.data',
    ]
)
