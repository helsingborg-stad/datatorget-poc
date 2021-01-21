using System;
using RabbitMQ.Client;

namespace kopplingstjanst
{
    class Program
    {
        static void Main(string[] args)
        {
            for (var i = 0; i < 10; i++)
            {
                try
                {
                    Listen();
                }
                catch (Exception ex)
                {
                    Console.WriteLine($"Error: {ex.Message}");
                    Console.WriteLine("Waiting 10 seconds before retrying.");
                    System.Threading.Thread.Sleep(10000);
                }
            }

            Console.WriteLine("Fatal error. Terminating application.");
        }

        private static void Listen()
        { 
            var factory = new ConnectionFactory { HostName = _Config.MessageServiceHost, Port = _Config.MessageServicePort, UserName = _Config.MessageServiceUserName, Password = _Config.MessageServicePassword };
            using (var connection = factory.CreateConnection())
            using (var model = connection.CreateModel())
            {
                //var svc1 = new BokningTillBetalorder(model, "bokning", _Config.BetalningsApi);
                //var svc2 = new BetalningTillBokning(model, "betalning", _Config.BokningApi);

                model.ExchangeDeclare(exchange: "bokning", type: ExchangeType.Fanout, durable: false, autoDelete: false);
                model.QueueDeclare(queue: "bokning_frends", durable: false, exclusive: false, autoDelete: false);
                model.QueueBind(queue: "bokning_frends", exchange: "bokning", routingKey: "");

                model.ExchangeDeclare(exchange: "betalning", type: ExchangeType.Fanout, durable: false, autoDelete: false);
                model.QueueDeclare(queue: "betalning_frends", durable: false, exclusive: false, autoDelete: false);
                model.QueueDeclare(queue: "betalning_frends2", durable: false, exclusive: false, autoDelete: false);
                model.QueueBind(queue: "betalning_frends", exchange: "betalning", routingKey: "");
                model.QueueBind(queue: "betalning_frends2", exchange: "betalning", routingKey: "");

                Console.WriteLine("Started successfully");

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
