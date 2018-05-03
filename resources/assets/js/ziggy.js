    var Ziggy = {
        namedRoutes: {"home":{"uri":"home","methods":["GET","HEAD"],"domain":null},"financial.files.store":{"uri":"financiero\/gestion-de-archivos\/solicitudes\/estudiantes","methods":["POST"],"domain":null},"financial.files.update":{"uri":"financiero\/gestion-de-archivos\/solicitudes\/estudiantes\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.files.request.update":{"uri":"financiero\/gestion-de-archivos\/solicitudes\/aprobaciones\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.requests.student.extension.index":{"uri":"financiero\/solicitudes\/supletorios","methods":["GET","HEAD"],"domain":null},"financial.requests.student.extension.create":{"uri":"financiero\/solicitudes\/supletorios\/create","methods":["GET","HEAD"],"domain":null},"financial.requests.student.extension.store":{"uri":"financiero\/solicitudes\/supletorios","methods":["POST"],"domain":null},"financial.requests.student.extension.edit":{"uri":"financiero\/solicitudes\/supletorios\/{id}\/edit","methods":["GET","HEAD"],"domain":null},"financial.requests.student.extension.update":{"uri":"financiero\/solicitudes\/supletorios\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.requests.student.extension.destroy":{"uri":"financiero\/solicitudes\/supletorios\/{id}","methods":["DELETE"],"domain":null},"financial.requests.student.add-sub.index":{"uri":"financiero\/solicitudes\/adicion-cancelacion-de-materias","methods":["GET","HEAD"],"domain":null},"financial.requests.student.add-sub.create":{"uri":"financiero\/solicitudes\/adicion-cancelacion-de-materias\/create","methods":["GET","HEAD"],"domain":null},"financial.requests.student.add-sub.store":{"uri":"financiero\/solicitudes\/adicion-cancelacion-de-materias","methods":["POST"],"domain":null},"financial.requests.student.add-sub.edit":{"uri":"financiero\/solicitudes\/adicion-cancelacion-de-materias\/{id}\/edit","methods":["GET","HEAD"],"domain":null},"financial.requests.student.add-sub.update":{"uri":"financiero\/solicitudes\/adicion-cancelacion-de-materias\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.requests.student.add-sub.destroy":{"uri":"financiero\/solicitudes\/adicion-cancelacion-de-materias\/{id}","methods":["DELETE"],"domain":null},"financial.requests.student.validation.index":{"uri":"financiero\/solicitudes\/validacion","methods":["GET","HEAD"],"domain":null},"financial.requests.student.validation.create":{"uri":"financiero\/solicitudes\/validacion\/create","methods":["GET","HEAD"],"domain":null},"financial.requests.student.validation.store":{"uri":"financiero\/solicitudes\/validacion","methods":["POST"],"domain":null},"financial.requests.student.validation.edit":{"uri":"financiero\/solicitudes\/validacion\/{id}\/edit","methods":["GET","HEAD"],"domain":null},"financial.requests.student.validation.update":{"uri":"financiero\/solicitudes\/validacion\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.requests.student.validation.destroy":{"uri":"financiero\/solicitudes\/validacion\/{id}","methods":["DELETE"],"domain":null},"financial.requests.student.intersemestral.index":{"uri":"financiero\/solicitudes\/intersemestral","methods":["GET","HEAD"],"domain":null},"financial.requests.student.intersemestral.create":{"uri":"financiero\/solicitudes\/intersemestral\/create","methods":["GET","HEAD"],"domain":null},"financial.requests.student.intersemestral.store":{"uri":"financiero\/solicitudes\/intersemestral","methods":["POST"],"domain":null},"financial.requests.student.intersemestral.edit":{"uri":"financiero\/solicitudes\/intersemestral\/{id}\/edit","methods":["GET","HEAD"],"domain":null},"financial.requests.student.intersemestral.update":{"uri":"financiero\/solicitudes\/intersemestral\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.requests.student.intersemestral.destroy":{"uri":"financiero\/solicitudes\/intersemestral\/{id}","methods":["DELETE"],"domain":null},"financial.money.cash.index":{"uri":"financiero\/dineros\/caja-menor","methods":["GET","HEAD"],"domain":null},"financial.money.cash.store":{"uri":"financiero\/dineros\/caja-menor","methods":["POST"],"domain":null},"financial.money.cash.update":{"uri":"financiero\/dineros\/caja-menor\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.money.cash.destroy":{"uri":"financiero\/dineros\/caja-menor\/{id}","methods":["DELETE"],"domain":null},"financial.money.checks.index":{"uri":"financiero\/dineros\/cheques","methods":["GET","HEAD"],"domain":null},"financial.money.checks.store":{"uri":"financiero\/dineros\/cheques","methods":["POST"],"domain":null},"financial.money.checks.update":{"uri":"financiero\/dineros\/cheques\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.money.checks.destroy":{"uri":"financiero\/dineros\/cheques\/{id}","methods":["DELETE"],"domain":null},"financial.admin.approval.extension.update":{"uri":"financiero\/administrativo\/aprobaciones\/supletorios\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.admin.approval.validation.update":{"uri":"financiero\/administrativo\/aprobaciones\/validaciones\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.admin.approval.addition.subtraction.update":{"uri":"financiero\/administrativo\/aprobaciones\/adicion-cancelacion\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.admin.approval.intersemestral.store":{"uri":"financiero\/administrativo\/aprobaciones\/intersemestral","methods":["POST"],"domain":null},"financial.admin.approval.intersemestral.update":{"uri":"financiero\/administrativo\/aprobaciones\/intersemestral\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.management.programs.store":{"uri":"financiero\/recursos\/programas","methods":["POST"],"domain":null},"financial.management.programs.update":{"uri":"financiero\/recursos\/programas\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.management.programs.destroy":{"uri":"financiero\/recursos\/programas\/{id}","methods":["DELETE"],"domain":null},"financial.management.subjects.store":{"uri":"financiero\/recursos\/materias","methods":["POST"],"domain":null},"financial.management.subjects.update":{"uri":"financiero\/recursos\/materias\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.management.subjects.destroy":{"uri":"financiero\/recursos\/materias\/{id}","methods":["DELETE"],"domain":null},"financial.management.subjects.programs.teachers.index":{"uri":"financiero\/recursos\/materias-programas-docentes","methods":["GET","HEAD"],"domain":null},"financial.management.subjects.programs.teachers.store":{"uri":"financiero\/recursos\/materias-programas-docentes","methods":["POST"],"domain":null},"financial.management.subjects.programs.teachers.update":{"uri":"financiero\/recursos\/materias-programas-docentes","methods":["PUT"],"domain":null},"financial.management.subjects.programs.teachers.destroy":{"uri":"financiero\/recursos\/materias-programas-docentes","methods":["DELETE"],"domain":null},"financial.management.status.store":{"uri":"financiero\/recursos\/estados-de-solicitudes","methods":["POST"],"domain":null},"financial.management.status.update":{"uri":"financiero\/recursos\/estados-de-solicitudes\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.management.status.destroy":{"uri":"financiero\/recursos\/estados-de-solicitudes\/{id}","methods":["DELETE"],"domain":null},"financial.management.costs.store":{"uri":"financiero\/recursos\/costos-solicitudes","methods":["POST"],"domain":null},"financial.management.costs.update":{"uri":"financiero\/recursos\/costos-solicitudes\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.management.costs.destroy":{"uri":"financiero\/recursos\/costos-solicitudes\/{id}","methods":["DELETE"],"domain":null},"financial.management.file.type.store":{"uri":"financiero\/recursos\/tipos-de-archivos","methods":["POST"],"domain":null},"financial.management.file.type.update":{"uri":"financiero\/recursos\/tipos-de-archivos\/{id}","methods":["PUT","PATCH"],"domain":null},"financial.management.file.type.destroy":{"uri":"financiero\/recursos\/tipos-de-archivos\/{id}","methods":["DELETE"],"domain":null},"financial.management.available.modules.index":{"uri":"financiero\/recursos\/disponibilidad-de-modulos","methods":["GET","HEAD"],"domain":null},"financial.management.available.modules.store":{"uri":"financiero\/recursos\/disponibilidad-de-modulos","methods":["POST"],"domain":null},"financial.api.options.programs":{"uri":"financiero\/api\/options\/programs","methods":["GET","HEAD"],"domain":null},"financial.api.options.programs.subjects":{"uri":"financiero\/api\/options\/programs\/{id}\/subjects","methods":["GET","HEAD"],"domain":null},"financial.api.options.programs.subjects.teachers":{"uri":"financiero\/api\/options\/programs\/subjects\/{id}\/teachers","methods":["GET","HEAD"],"domain":null},"financial.api.options.teachers":{"uri":"financiero\/api\/options\/teachers","methods":["GET","HEAD"],"domain":null},"financial.api.options.subjects":{"uri":"financiero\/api\/options\/subjects","methods":["GET","HEAD"],"domain":null},"financial.api.options.subjects.show":{"uri":"financiero\/api\/options\/subjects\/show\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.options.requests-list.all":{"uri":"financiero\/api\/options\/requests-list","methods":["GET","HEAD"],"domain":null},"financial.api.options.file-type.options":{"uri":"financiero\/api\/options\/file-type","methods":["GET","HEAD"],"domain":null},"financial.api.options.file.status.options":{"uri":"financiero\/api\/options\/file-status","methods":["GET","HEAD"],"domain":null},"financial.api.datatables.extensions":{"uri":"financiero\/api\/datatables\/extensions","methods":["GET","HEAD"],"domain":null},"financial.api.datatables.add-sub":{"uri":"financiero\/api\/datatables\/additions-subtractions","methods":["GET","HEAD"],"domain":null},"financial.api.datatables.validation":{"uri":"financiero\/api\/datatables\/validation","methods":["GET","HEAD"],"domain":null},"financial.api.datatables.intersemestral":{"uri":"financiero\/api\/datatables\/intersemestral","methods":["GET","HEAD"],"domain":null},"financial.api.datatables.programs":{"uri":"financiero\/api\/datatables\/programs","methods":["GET","HEAD"],"domain":null},"financial.api.datatables.subjects":{"uri":"financiero\/api\/datatables\/subjects","methods":["GET","HEAD"],"domain":null},"financial.api.datatables.cost":{"uri":"financiero\/api\/datatables\/costs","methods":["GET","HEAD"],"domain":null},"financial.api.datatables.file-type":{"uri":"financiero\/api\/datatables\/file-types","methods":["GET","HEAD"],"domain":null},"financial.api.datatables.checks":{"uri":"financiero\/api\/datatables\/checks","methods":["GET","HEAD"],"domain":null},"financial.api.datatables.cash":{"uri":"financiero\/api\/datatables\/petty-cash","methods":["GET","HEAD"],"domain":null},"financial.api.extension.comments.index":{"uri":"financiero\/api\/comments\/extension\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.extension.comments.store":{"uri":"financiero\/api\/comments\/extension\/store","methods":["POST"],"domain":null},"financial.api.add-sub.comments.index":{"uri":"financiero\/api\/comments\/addition-subtraction\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.add-sub.comments.store":{"uri":"financiero\/api\/comments\/addition-subtraction\/store","methods":["POST"],"domain":null},"financial.api.validation.comments.index":{"uri":"financiero\/api\/comments\/validation\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.validation.comments.store":{"uri":"financiero\/api\/comments\/validation\/store","methods":["POST"],"domain":null},"financial.api.intersemestral.comments.index":{"uri":"financiero\/api\/comments\/intersemestral\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.intersemestral.comments.store":{"uri":"financiero\/api\/comments\/intersemestral\/store","methods":["POST"],"domain":null},"financial.api.file.comment.index":{"uri":"financiero\/api\/comments\/file\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.file.comment.store":{"uri":"financiero\/api\/comments\/file\/store","methods":["POST"],"domain":null},"financial.api.tree.status-request":{"uri":"financiero\/api\/tree\/status-request\/{type}","methods":["GET","HEAD"],"domain":null},"financial.api.editable.cost":{"uri":"financiero\/api\/editable\/costs","methods":["GET","HEAD"],"domain":null},"financial.api.files.own.files":{"uri":"financiero\/api\/files\/own","methods":["GET","HEAD"],"domain":null},"financial.api.files.approved.files":{"uri":"financiero\/api\/files\/approved","methods":["GET","HEAD"],"domain":null},"financial.api.files.pending.files":{"uri":"financiero\/api\/files\/pending","methods":["GET","HEAD"],"domain":null},"financial.api.files.show.auth":{"uri":"financiero\/api\/files\/show\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.stats.financial.supply":{"uri":"financiero\/api\/stats\/financial-supply","methods":["GET","HEAD"],"domain":null},"financial.api.extension.show":{"uri":"financiero\/api\/extension\/show\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.extension.edit":{"uri":"financiero\/api\/extension\/edit\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.add-sub.show":{"uri":"financiero\/api\/addition-subtraction\/show\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.add-sub.edit":{"uri":"financiero\/api\/addition-subtraction\/edit\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.validation.show":{"uri":"financiero\/api\/validation\/show\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.validation.edit":{"uri":"financiero\/api\/validation\/edit\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.intersemestral.show":{"uri":"financiero\/api\/intersemestral\/show\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.intersemestral.admin":{"uri":"financiero\/api\/intersemestral\/show-admin\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.intersemestral.available":{"uri":"financiero\/api\/intersemestral\/available","methods":["GET","HEAD"],"domain":null},"financial.api.intersemestral.edit":{"uri":"financiero\/api\/intersemestral\/edit\/{id}","methods":["GET","HEAD"],"domain":null},"financial.api.approval.sidebar.extension":{"uri":"financiero\/api\/approval\/sidebar\/extension","methods":["GET","HEAD"],"domain":null},"financial.api.approval.sidebar.validation":{"uri":"financiero\/api\/approval\/sidebar\/validation","methods":["GET","HEAD"],"domain":null},"financial.api.approval.sidebar.addition.subtraction":{"uri":"financiero\/api\/approval\/sidebar\/addition-subtraction","methods":["GET","HEAD"],"domain":null},"financial.api.approval.sidebar.intersemestral":{"uri":"financiero\/api\/approval\/sidebar\/intersemestral","methods":["GET","HEAD"],"domain":null},"financial.api.approval.extensions":{"uri":"financiero\/api\/approval\/extensions\/{status?}","methods":["GET","HEAD"],"domain":null},"financial.api.approval.validation":{"uri":"financiero\/api\/approval\/validations\/{status?}","methods":["GET","HEAD"],"domain":null},"financial.api.approval.addition.subtraction":{"uri":"financiero\/api\/approval\/addition-subtraction\/{status?}","methods":["GET","HEAD"],"domain":null},"financial.api.approval.intersemestral":{"uri":"financiero\/api\/approval\/intersemestral\/{status?}","methods":["GET","HEAD"],"domain":null},"financial.api.user.auth":{"uri":"financiero\/api\/user\/auth","methods":["GET","HEAD"],"domain":null},"financial.api.available.modules":{"uri":"financiero\/api\/available-modules","methods":["GET","HEAD"],"domain":null}},
        baseUrl: window.location.origin+'/',
        baseProtocol: window.location.protocol,
        baseDomain: window.location.hostname,
        basePort: (window.location.port) ? window.location.port : false
    };

    export {
        Ziggy
    }