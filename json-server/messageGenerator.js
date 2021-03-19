var faker = require('faker');

function generateData () {
  var messages = [];
  for (var id = 1; id <= 100; id++) {
	let person_id= faker.random.number({min: 1, max: 8});
	let to_person_id = faker.random.number({min: 1, max: 8});
	let date = faker.date.between("2021-01-01", "2021-07-31").toISOString().split("T")[0];
    let customer_name = faker.name.firstName();
    let message = faker.hacker.phrase();
    messages.push({
      "id": id,
	"person_id": person_id,
	"to_person_id": to_person_id,
      "customer_name": customer_name,

      "messages": message,
	"date": date,
    });
  }
  return {messages};
}

module.exports = generateData;
