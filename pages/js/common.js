const disapprovedMemo = async(rst_id) => {
	await $.ajax({
        url: 'http://192.168.3.31/TrainingRecordDatabaseSystem/rapidDisapprovedHRMemo',
        method: "post",
        data: {
        	_token: '',
        	rst_id,
        }
    })
}