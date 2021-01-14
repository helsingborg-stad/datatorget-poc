using System;
using System.IO;

namespace krakendconfig
{
    class Program
    {
        static void Main(string[] args)
        {
            var result = Configurator.Create();
            Console.WriteLine(result);
            File.WriteAllText(@"C:\Temp\krakend.json", result);
        }
    }
}
