using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace betalningsapi.code
{
    public class Betalorder
    {
        public string Betalorderid { get; set; }
        public string Applikation { get; set; }
        public string Referens { get; set; }
        public string Beskrivning { get; set; }
        public int Kundnr { get; set; }
        public int BeloppTotalt { get; set; }
        public int BeloppBetalt { get; set; }
    }
}
