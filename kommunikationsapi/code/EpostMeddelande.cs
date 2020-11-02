using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace kommunikationsapi.code
{
    public class EpostMeddelande
    {
        public string Id { get; set; }
        public string MottagareEpost { get; set; }
        public string AvsandareEpost { get; set; }
        public string Amne { get; set; }
        public string Meddelandetext { get; set; }
        public DateTime Leveranstid { get; set; }
        public string Referens { get; set; }
        public string Applikation { get; set; }
    }
}
