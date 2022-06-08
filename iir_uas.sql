-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jun 2022 pada 08.05
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iir_uas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `crawl`
--

CREATE TABLE `crawl` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `cite` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `crawl`
--

INSERT INTO `crawl` (`id`, `title`, `link`, `cite`, `keyword`) VALUES
(1, 'Information Technology and Corporate Strategy: A Research Perspective', 'http://localhost:8080/phpmyadmin/index.php?route=/table/change&db=iir_uas&table=crawl', 1153, 'Information Security'),
(2, '<b>PDF </b>methods for turbulent reactive flows', 'https://www.sciencedirect.com/science/article/pii/0360128585900024', 3445, 'pdf'),
(3, 'LAGRANGI-AN <b>PDF </b>METHODS FOR TURBULENT FLOWS', 'https://tcg.mae.cornell.edu/pubs/Pope_ARFM_94.pdf', 802, 'pdf'),
(4, 'The <b>pdf </b>approach to turbulent polydispersed two-phase flows', 'https://www.sciencedirect.com/science/article/pii/S0370157301000114', 358, 'pdf'),
(5, 'The probability density function (<b>pdf</b>) approach to reacting turbulent flows', 'https://link.springer.com/content/pdf/10.1007/3540101926_11.pdf', 310, 'pdf'),
(6, 'Layout-aware text extraction from full-text <b>PDF </b>of scientific articles', 'https://link.springer.com/article/10.1186/1751-0473-7-7', 141, 'pdf'),
(7, 'Emotions and Bodily Changes. a Survey of Literature on Psychosomatic Interrelationships 1910&#8211;1933', 'https://www.degruyter.com/document/doi/10.7312/dunb91000/html?lang=de', 1921, 'pdf'),
(8, 'Towards adversarial malware detection: Lessons learned from <b>PDF</b>-based attacks', 'https://dl.acm.org/doi/abs/10.1145/3332184', 53, 'pdf'),
(9, 'The <b>pdf </b>approach to turbulent flow', 'https://link.springer.com/article/10.1007/BF00271582', 122, 'pdf'),
(10, 'Detection of malicious <b>PDF </b>files and directions for enhancements: A state-of-the art survey', 'https://www.sciencedirect.com/science/article/pii/S0167404814001606', 94, 'pdf'),
(11, 'Mean-field/<b>PDF </b>numerical approach for polydispersed turbulent two-phase flows', 'https://www.sciencedirect.com/science/article/pii/S0360128506000025', 109, 'pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `title` varchar(2000) NOT NULL,
  `number_citations` int(200) NOT NULL,
  `authors` varchar(2000) NOT NULL,
  `abstract` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `data`
--

INSERT INTO `data` (`id`, `title`, `number_citations`, `authors`, `abstract`) VALUES
(1, 'Information Technology and Corporate Strategy: A Research Perspective', 1153, 'J. Yannis Bakos and Michael E. Treacy', 'The use of information technology (IT) as a competitive weapon has become a popular cliche; but there is still a marked lack of understanding of the issues that determine the influence of information technology on a particular organization and the processes that will allow a smooth coordination of technology and corporate strategy. This article surveys the major efforts to arrive at a relevent framework, and attempts to integrate them in a more comprehensive viewpoint. The focus then turns to the major research issues in understanding the impact of information technology on competitive strategy.'),
(2, 'The role of information technology in the organization: a review, model, and assessment', 1249, 'Todd Dewetta & Gareth RJonesa', 'This paper reviews and extends recent scholarly and popular literature to provide a broad overview of how information technology (IT) impacts organizational characteristics and outcomes. First, based on a review of the literature, we describe two of the principal performance enhancing benefits of IT: information efficiencies and information synergies, and identify five main organizational outcomes of the application of IT that embody these benefits. We then discuss the role that IT plays in moderating the relationship between organizational characteristics including structure, size, learning, culture, and interorganizational relationships and the most strategic outcomes, organizational efficiency and innovation. Throughout we discuss the limitations and possible negative consequences of the use of IT and close by considering several key areas for future research.'),
(3, 'Information Technology and Productivity: A Review of the Literature', 1085, 'Erik Brynjolfsson & Shinkyu Yang', 'In recent years, the relationship between information technology (IT) and productivity has become a source of debate. In the 1980s and early 1990s, empirical research on IT productivity generally did not identify significant productivity improvements. More recently, as new data are identified and more sophisticated methodologies are applied, several researchers have found evidence that IT is associated not only with improvement in productivity, but also in intermediate measures, consumer surplus, and economic growth. Nonetheless, new questions emerge as old puzzles fade. This survey reviews the literature, identifies remaining questions, and concludes with recommendations for applications of traditional methodologies to new data sources, as well as alternative, broader metrics of welfare to assess and enhance the benefits of IT.'),
(4, 'The Use of Information Technology to Enhance Management School Education: A Theoretical View', 1723, 'Dorothy E. Leidner and Sirkka L. Jarvenpaa', 'To use information technology to improve learning processes, the pedagogical assumptions underlying the design of information technology for educational purposes must be understood. This paper reviews different models of learning, surfaces assumptions of electronic teaching technology, and relates those assumptions to the differing models of learning. Our analysis suggests that initial attempts to bring information technology to management education follow a classic story of automating rather than transforming. IT is primarily used to automate the information delivery function in classrooms. In the absence of fundamental changes to the teaching and learning process, such classrooms may do little but speed up ineffective processes and methods of teaching. Our mapping of technologies to learning models identifies sets of technologies in which management schools should invest in order to informate up and down and ultimately transform the educational environment and processes. For researchers interested in the use of information technology to improve learning processes, the paper provides a theoretical foundation for future work.'),
(5, 'Research on information technology in the hospitality industry', 288, 'Peter O’ Connor & Jamie Murphy', 'This paper reviews recent research on information technology in the hospitality industry. The analysis revealed three broad research areas: the Internet\'s effects on distribution; on pricing; and on consumer interactions. Similar to aftermath of the dot com boom, the hospitality industry is realising that the information technology has unintended effects and prognosticators are often wrong. While the reviewed articles provide sound advice for hospitality operators and a rich stream of future research for academics, poor rigor and a lack of relevance throughout the reviewed journals underscore a worrying trend in hospitality research.'),
(6, 'User Acceptance of Information Technology: Theories and Models\r\n', 1363, 'Andrew Dillon & Michael G. Morris', 'Reviews literature in user acceptance and resistance to information technology design and implementation. Examines innovation diffusion, technology design and implementation, human-computer interaction, and information systems. Concentrates on the determinants of user acceptance and resistance and emphasizes how researchers and developers can predict levels of user acceptance. (Contains 126 references.) (PEN)'),
(7, 'Past, present & future of information technology in pedometrics', 47, 'David G.Rossiter', 'Although pedometric approaches were taken as early as 1925, the post-WWII development of information technology radically transformed the possibilities for applying mathematical methods to soil science. The most significant development is the digital computer and associated developments in computer science. These allowed statistical inference on large pedometric datasets, e.g., numerical taxonomy of soils from the early 1960s and geostatistics from the mid-1970s, as well as simulation models of soil processes. By the time of the first Pedometrics conference in 1992 sufficient computing power was available for stochastic simulation and complex geostatistical procedures such as disjunctive kriging. In the intervening 25 years computing power has grown to almost magical proportions, allowing individual scientists to carry out complex procedures. A second development is the growth of networking. This facilitates collaboration among pedometricians, rapid communication with journals, collaborative programming and publication, and easy access to resources. A third development is the availability of on-line storage of large datasets, especially of open data, including GIS coverages and remotely-sensed images. This allows pedometricians working on geographic problems to integrate sources from multiple disciplines, most notably in digital soil mapping using a wide variety of covariates related to soil genesis. It also promotes the an open-source movement of collaborative development of computer programs useful for pedometrics. A fourth development is the wide range of digital sensors which provide data for pedometrics; sensors include spectroscopy, electromagnetic induction, and γ-ray detectors., connected to each other and to central data stores. A fifth development is wireless technology, including mobile computing and telephony, again greatly facilitating rapid and extensive data collection – in pedometrics, the more dense the data, the greater the analytical possibilities and the lower the uncertainty. A final development is a global navigation satellite system (e.g., GPS), making accurate georeference of field data a routine part of data collection, and thereby assuring the highest possible accuracy in maps made by predictive pedometric methods. As computer power increases, models can be correspondingly detailed. As sensor networks and remote sensing provide ever more abundant and spatiotemporally fine-resolution measurements, the challenge is to manage this information and maintain the link with pedologic and soil-landscape knowledge, within the context of societal needs for the results of pedometric analysis.'),
(8, 'Information Technology Diffusion: A Review of\r\nEmpirical Research\r\n', 974, 'Robert G. Fichman', 'Innovation diffusion theory provides a useful perspective on one of the most persistently challenging topics in the IT\r\nfield, namely, how to improve technology assessment, adoption and implementation. For this reason, diffusion is\r\ngrowing in popularity as a reference theory for empirical studies of information technology adoption and diffusion,\r\nalthough no comprehensive review of this body of work has been published to date. This paper presents the results\r\nof a critical review of eighteen empirical studies published during the period 1981-1991. Conclusive results were\r\nmost likely when the adoption context closely matched the contexts in which classical diffusion theory was\r\ndeveloped (for example, individual adoption of personal-use technologies), or when researchers extended diffusion\r\ntheory to account for new factors specific to the IT adoption context under study.\r\nBased on classical diffusion theory and other recent conceptual work, a framework is developed to guide future\r\nresearch in IT diffusion. The framework maps two classes of technology (ones that conform closely to classical\r\ndiffusion assumptions versus ones that do not) against locus of adoption (individual versus organizational), resulting\r\nin four IT adoption contexts. For each adoption context, variables impacting adoption and diffusion are identified.\r\nAdditionally, directions for future research are discussed.'),
(11, 'Why do people use information technology? A critical review of the technology acceptance model', 5859, 'Paul Legris  ,John Ingham & Pierre Collerette', 'Information systems (IS) implementation is costly and has a relatively low success rate. Since the seventies, IS research has contributed to a better understanding of this process and its outcomes. The early efforts concentrated on the identification of factors that facilitated IS use. This produced a long list of items that proved to be of little practical value. It became obvious that, for practical reasons, the factors had to be grouped into a model in a way that would facilitate analysis of IS use.\r\n\r\nIn 1985, Fred Davis suggested the technology acceptance model (TAM). It examines the mediating role of perceived ease of use and perceived usefulness in their relation between systems characteristics (external variables) and the probability of system use (an indicator of system success). More recently, Davis proposed a new version of his model: TAM2. It includes subjective norms, and was tested with longitudinal research designs. Overall the two explain about 40% of system’s use. Analysis of empirical research using TAM shows that results are not totally consistent or clear. This suggests that significant factors are not included in the models.\r\n\r\nWe conclude that TAM is a useful model, but has to be integrated into a broader one which would include variables related to both human and social change processes, and to the adoption of the innovation model.'),
(12, 'Measuring the costs and benefits of information technology in construction', 170, 'ROGER FLANAGAN & LAURENCE MARSH', 'Information technology (IT) has been widely applied across many economic sectors in order to increase competitiveness and reduce costs. This paper identifies that uptake of IT within construction is low. It is argued that significant barriers preventing construction organizations from investing in IT include uncertainty concerning the identification and measurement of benefits associated with applications. In particular, it is argued that difficulties in quantifying benefits associated with improved information availability and decision making prevent effective IT cost/benefit analysis. Existing approaches to evaluating IT within construction are reviewed. A framework is presented which identifies metrics by which IT impacts both management and operational processes within construction in order to deliver value. An evaluation methodology tailored to one specific IT application, high‐density bar coding in maintenance management, is presented to illustrate the quantification of both the costs and benefits of applying IT.'),
(13, 'Information technology and systems justification: A review for research and applications', 342, 'A.Gunasekaran ,E.W.T.Ngai & R.E.McGaughey', 'Information technology (IT) such as Electronic Data Interchange (EDI), Radio Frequency Identification Technology (RFID), wireless, the Internet and World Wide Web (WWW), and Information Systems (IS) such as Electronic Commerce (E-Commerce) systems and Enterprise Resource Planning (ERP) systems have had tremendous impact in education, healthcare, manufacturing, transportation, retailing, pure services, and even war. Many organizations turned to IT/IS to help them achieve their goals; however, many failed to achieve the full potential of IT/IS. These failures can be attributed at least in part to a weak link in the planning process. That weak link is the IT/IS justification process. The decision-making process has only grown more difficult in recent years with the increased complexity of business brought about by the rapid growth of supply chain management, the virtual enterprise and E-business. These are but three of the many changes in the business environment over the past 10–12 years. The complexities of this dynamic new business environment should be taken into account in IT/IS justification. We conducted a review of the current literature on IT/IS justification. The purpose of the literature review was to assemble meaningful information for the development of a framework for IT/IS evaluation that better reflects the new business environment. A suitable classification scheme has been proposed for organizing the literature reviewed. Directions for future research are indicated.\r\n\r\n'),
(14, 'Recent applications of economic theory in information Technology research', 301, 'J.Yannis Bakos & Chris F.Kemerer', 'Academicians and practitioners are becoming increasingly interested in the economics of Information Technology (IT). In part, this interest stems from the increased role that IT now plays in the strategic thinking of most large organizations, and from the significant dollar costs expended by these organizations on IT. Naturally enough, researchers are turning to economics as a reference discipline in their attempt to answer questions concerning both the value added by IT and the true cost of providing IT resources. This increased interest in the economics of IT is manifested in the application of a number of aspects of economic theory in recent information systems research, leading to results that have appeared in a wide variety of publication outlets This article reviews this work and provides a systematic categorization as a first step in establishing a common research tradition, and to serve as an introduction for researchers beginning work in this area. Six areas of economic theory are represented: Information economics, production economics, economic models of organizational performance, industrial organization, institutional economics (agency theory and transaction cost theory), and macroeconomic studies of IT impact. For each of these areas, recent work is reviewed and suggestions for future research are provided.\r\n\r\n'),
(15, 'Literature Review of Information Technology Adoption Models at Firm Level\r\n', 1743, 'Tiago Oliveira & Maria Fraga Martins', 'Today, information technology (IT) is universally regarded as an essential tool in enhancing the competitiveness of the economy of a country. There is consensus that IT has significant effects on the productivity of firms. These effects will only be realized if, and when, IT are widely spread and used. It is essential to understand the determinants of IT adoption. Consequently it is necessary to know the theoretical models. There are few reviews in the literature about the comparison of IT adoption models at the individual level, and to the best of our knowledge there are even fewer at the firm level. This review will fill this gap. In this study, we review theories for adoption models at the firm level used in information systems literature and discuss two prominent models: diffusion on innovation (DOI) theory, and the technology, organization, and environment (TOE) framework. The DOI found that individual characteristics, internal characteristics of organizational structure, and external characteristics of the organization are important antecedents to organizational innovativeness. The TOE framework identifies three aspects of an enterprise\'s context that influence the process by which it adopts and implements a technological innovation: technological context, organizational context, and environmental context. We made a thorough analysis of the TOE framework, analysing the studies that used only this theory and the studies that combine the TOE framework with other theories such as: DOI, institutional theory, and the Iacovou, Benbasat, and Dexter model. The institutional theory helps us to understand the factors that influence the adoption of interorganizational systems (IOSs); it postulates that mimetic, coercive, and normative institutional pressures existing in an institutionalized environment may influence the organization’s predisposition toward an IT‑based interorganizational system. The Iacovou, Benbasat, and Dexter model, analyses IOSs characteristics that influence firms to adopt IT innovations. It is based on three contexts: perceived benefits, organizational readiness, and external pressure. The analysis of these models takes into account the empirical literature, and the difference between independent and dependent variables. The paper also makes recommendations for future research.'),
(16, 'Using information technology to improve the management of chronic disease', 327, 'Branko G Celler PhD, Nigel H Lovell PhD , Jim Basilakis MB BS & Research Associate', 'Information and communications technology (ICT) is increasingly being used in management of chronic illness to facilitate shared services (virtual health networks and electronic health records), knowledge management (care rules and protocols, scheduling, information directories), as well as consumer-based health education and evidence-based clinical protocols.\r\nCommon applications of ICT include home monitoring of vital signs for patients with chronic disease, as well as replacing home visits by nurses in person with telemedicine videophone consultations.\r\nA patient-managed Home Telecare System with integrated clinical signs monitoring, automated scheduling and medication reminders, as well as access to health education and daily logs, is presented as an example of ICT use for chronic disease self-management.\r\nA clinical case study demonstrates how early identification of adverse trends in clinical signs recorded in the home can either avoid hospital readmission or reduce the length of hospital stay.'),
(17, 'Information technology in health promotion ', 91, 'T. P. Lintonen & A.I.Konu, D. Seedhouse', 'eHealth, the use of information technology to improve or enable health and health care, has recently been high on the health care development agenda. Given the vivid interest in eHealth, little reference has been made to the use of these technologies in the promotion of health. The aim of this present study was to conduct a review on recent uses of information technology in health promotion through looking at research articles published in peer-reviewed journals. Fifteen relevant journals with issues published between 2003 and June 2005 yielded altogether 1352 articles, 56 of which contained content related to the use of information technology in the context of health promotion. As reflected by this rather small proportion, research on the role of information technology is only starting to emerge. Four broad thematic application areas within health promotion were identified: use of information technology as an intervention medium, use of information technology as a research focus, use of information technology as a research instrument and use of information technology for professional development. In line with this rather instrumental focus, the concepts ‘ePromotion of Health’ or ‘Health ePromotion’ would come close to describing the role of information technology in health promotion.'),
(18, 'Smart City and information technology: A review', 165, 'Andrés Camero & Enrique Alba', 'Smart City is a recent concept that is gaining momentum in public opinion, and thus, it is making its way into the agendas of researchers and city authorities all over the world. However, there is no consensus of what exactly is a smart city, and academic research is, at best, building applications in numerous silos. This paper explores the computer science and information technology literature about Smart City. Using data analysis techniques, we contribute to present the domain from an objective data-based point of view, aiming to highlight its major trends, and providing a single entry point for newcomers.'),
(19, 'Accounting for the Contradictory Organizational Consequences of Information Technology: Theoretical Directions and Methodological Implications', 1084, 'Daniel Robey & Marie-Claude Boudreau', 'Although much contemporary thought considers advanced information technologies as either determinants or enablers of radical organizational change, empirical studies have revealed inconsistent findings to support the deterministic logic implicit in such arguments. This paper reviews the contradictory empirical findings both across studies and within studies, and proposes the use of theories employing a logic of opposition to study the organizational consequences of information technology. In contrast to a logic of determination, a logic of opposition explains organizational change by identifying forces both promoting change and impeding change. Four specific theories are considered: organizational politics, organizational culture, institutional theory, and organizational learning. Each theory is briefly described to illustrate its usefulness to the problem of explaining information technology\'s role in organizational change. Four methodological implications of using these theories are also discussed: empirical identification of opposing forces, statement of opposing hypotheses, process research, and employing multiple interpretations.'),
(21, 'Advances in the application of information technology to sport performance', 524, 'Dario G. Liebermann,Larry Katz,Mike D. Hughes,Roger M. Bartlett,Jim McClements &Ian M. Franks', 'This paper overviews the diverse information technologies that are used to provide athletes with relevant feedback. Examples taken from various sports are used to illustrate selected applications of technology-based feedback. Several feedback systems are discussed, including vision, audition and proprioception. Each technology described here is based on the assumption that feedback would eventually enhance skill acquisition and sport performance and, as such, its usefulness to athletes and coaches in training is critically evaluated.'),
(22, 'Improving Modern Cancer Care Through Information Technology', 157, 'Steven B.ClauserPhD Edward H.WagnerMD, MPH Erin J.Aiello Bowles MPH ,Leah Tuzzio MPH ,Sarah M.GreeneMPH', 'The cancer care system is increasingly complex, marked by multiple hand-offs between primary care and specialty providers, inadequate communication among providers, and lack of clarity about a “medical home” (the ideal accountable care provider) for cancer patients. Patients and families often cite such difficulties as information deficits, uncoordinated care, and insufficient psychosocial support. This article presents a review of the challenges of delivering well coordinated, patient-centered cancer care in a complex modern healthcare system. An examination is made of the potential role of information technology (IT) advances to help both providers and patients. Using the published literature as background, a review is provided of selected work that is underway to improve communication, coordination, and quality of care. Also discussed are additional challenges and opportunities to advancing understanding of how patient data, provider and patient involvement, and informatics innovations can support high-quality cancer care.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `journals`
--

CREATE TABLE `journals` (
  `id` int(11) NOT NULL,
  `abstract` text NOT NULL,
  `author` varchar(500) NOT NULL,
  `data` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `journals`
--

INSERT INTO `journals` (`id`, `abstract`, `author`, `data`) VALUES
(1, 'The use of information technology (IT) as a competitive weapon has become a popular cliche; but there is still a marked lack of understanding of the issues that determine the influence of information technology on a particular organization and the processes that will allow a smooth coordination of technology and corporate strategy. This article surveys the major efforts to arrive at a relevent framework, and attempts to integrate them in a more comprehensive viewpoint. The focus then turns to the major research issues in understanding the impact of information technology on competitive strategy.', 'J. Yannis Bakos and Michael E. Treacy', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `crawl`
--
ALTER TABLE `crawl`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `abstract_title` (`data`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `crawl`
--
ALTER TABLE `crawl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `journals`
--
ALTER TABLE `journals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `journals`
--
ALTER TABLE `journals`
  ADD CONSTRAINT `abstract_title` FOREIGN KEY (`data`) REFERENCES `crawl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
