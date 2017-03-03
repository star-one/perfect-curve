function getOutcome()
{
  var strings = [
    'The ability to create smart data visualizations',
    'The profound behaviours of good',
    'A Town Hall for social change',
    'A democratic innovation revolution',
    'The difference between network and community',
    'True 21st century revolution',
    'Game-changing user choice',
    'A redistributive wealth economy',
    'Our socio-strategic dream',
    'Shifting systems to a relational node',
    'Evaluating the social value of big data research',
    'Inclusive growth',
    'Exploration of innovative & city-themed ideas from across the globe',
    'Decolonisation of investment',
    'Equating social innovation',
    'Social good and the economy will approach a new singularity',
    'Citizenry outsourcing our capacity to dream',
    'Putting the behaviours of good into play rather than outcomes',
    'A system where micro-financing models',
    'Economic and social resiliency',
    'Craftivist socio-political intervention',
    'The commodification of the narrative',
    'Democratisation of the information space',
    'Beliefs are made and unmade',
    'Creating a slice of the future we want',
    'Collaborative ecosystems of diversity',
    'Scalable economies of community',
    'Design, social activism and change',
    'A multiverse economy',
    'Liquid thinking',
    'Practical inspiration',
    'The storification of experience',
    'Social Media not Corporate Media',
    'We can build a Viable Innovation Approach',
    'Digital Transformation',
  ];
  
  var randomIndex = Math.floor(Math.random() * strings.length);
  var randomString = strings[randomIndex];
  return randomString;
}

function getLink()
{
  var strings = [
    'will be achieved',
    'can be stretched',
    'will come about',
    'is employed',
    'is hindered',
    'will develop',
    'can only be realised',
    'is a precondition',
    'is a prerequisite',
    'needs to be addressed',
    'must be a core investment',
    'may create diversity',
    'rather than over-stimulated resilience',
    'could work with communities',
    'can be gamified for social benefit',
    'will introduce a smarter city',
    'should create game-changing behaviours',
    'generates increased social capital',
    'may kickstart the sharing economy',
    '- converting social into local -',
    'from co-working to co-creating society',
    'as a function of systemic change',
    'breaking the hegemony of the elites',
    'by exploring traditions in the context of progress',
    'creating long-tail data maturity',
    'needs a Viable Innovation Approach',
    'will be transformed',
    'with development and transition',
  ];
  
  var randomIndex = Math.floor(Math.random() * strings.length);
  var randomString = strings[randomIndex];
  return randomString;
}

function getCondition()
{
  var strings = [
    'through the power of social media',
    'when the community acts as one',
    'for well developed social capital',
    'if trust is baked in',
    'by the democratisation of growth',
    'by innovative multi-agency platforms',
    'by unlocking the democratic capacity to innovate',
    'through the socio-dynamic ability to value-create',
    'to activate relationships',
    'for leveraging person-centred service',
    'to moving from risk-based to innovation-based service design',
    'in reversing the flow of a trust-diminished environment',
    'to remove the inequality of distribution of benefits of productivity and growth of wealth & revenue',
    'in creating the democratic context for all of us to contribute to growth in its broadest sense',
    'for eliminating the negative impacts of growth unequally attributed to those most vulnerable',
    'by creating economic & social resiliency',
    'through the gamification of society',
    'by democratising the information space',
    'when artivists mobilise as a demographic',
    'in taking a glimpse of the possible',
    'in a multiverse sharing economy',
    'through value-added social activism',
    'by embracing brokenness as an integral part of life',
    'when creativity is a collective responsibility',
    'through a Cities of Learning delivery model',
    'when people tell their own stories',
    'by storifying the experience model',
    'with a community noticeboard',
    'for a Viable Innovation Approach',
    'through transformational paradigm shift',
  ];
  
  var randomIndex = Math.floor(Math.random() * strings.length);
  var randomString = strings[randomIndex];
  return randomString;
}

function makeQuote()
{
  var d1 = document.getElementById('theStream');
  theQuote = "<article><p>\"" + getOutcome() + " " + getLink() + " " + getCondition() + "\"</p></article>";
//  document.write(theQuote);
  d1.insertAdjacentHTML('afterend', theQuote);
}