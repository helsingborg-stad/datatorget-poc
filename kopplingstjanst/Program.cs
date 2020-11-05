using System;
using RabbitMQ.Client;

namespace kopplingstjanst
{
    class Program
    {
        static void Main(string[] args)
        {
            var factory = new ConnectionFactory { HostName = _Config.MessageServiceHost, Port = _Config.MessageServicePort, UserName = _Config.MessageServiceUserName, Password = _Config.MessageServicePassword };
            using (var connection = factory.CreateConnection())
            using (var model = connection.CreateModel())
            {
                var svc1 = new BokningTillBetalorder(model, "bokning", _Config.BetalningsApi);
                var svc2 = new BetalningTillBokning(model, "betalning", _Config.BokningApi);



                //model.ExchangeDeclare(exchange: "bokning",
                //                    type: ExchangeType.Fanout,
                //                    durable: false,
                //                    autoDelete: false,
                //                    arguments: null);

                //var body = System.Text.Encoding.UTF8.GetBytes("{\"johan\":46,\"sven\":\"arboga\"}");

                //model.BasicPublish(exchange: "bokning",
                //                    routingKey: "",
                //                    basicProperties: null,
                //                    body: body);


                while (true)
                {
                    System.Threading.Thread.Sleep(3000);
                }
            }
        }
    }
}
